<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentApprovedMail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminPaymentController extends Controller
{
    // Daftar pembayaran masuk
    public function index(Request $request)
    {
        $query = Payment::with(['member', 'plan', 'method']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    // Approve pembayaran -> otomatis aktifkan member + set masa aktif + kirim email
    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses.');
        }

        $member = $payment->member;
        $plan = $payment->plan;

        // Set status pembayaran
        $payment->status = 'approved';
        $payment->approved_at = now();
        $payment->save();

        // Aktifkan member & set masa aktif (dari sekarang + days paket)
        $member->status = 'active';
        $member->subscription_start = now();
        $member->subscription_end = now()->addDays($plan->days ?? 30);
        $member->save();

        // Kirim email otomatis
        try {
            Mail::to($member->email)->send(new PaymentApprovedMail($payment));
        } catch (\Throwable $e) {
            // Abaikan jika email gagal agar tidak mengganggu proses approve
            \Illuminate\Support\Facades\Log::warning('Gagal kirim email payment approved: ' . $e->getMessage());
        }

        return back()->with('success', 'Pembayaran disetujui. Member diaktifkan & email terkirim.');
    }

    // Reject pembayaran
    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses.');
        }

        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $payment->status = 'rejected';
        $payment->admin_note = $request->admin_note;
        $payment->save();

        return back()->with('success', 'Pembayaran ditolak.');
    }
}
