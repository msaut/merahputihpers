<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    // Halaman pilih paket + riwayat pembayaran
    public function index()
    {
        $member = Auth::guard('member')->user();
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $methods = PaymentMethod::where('is_active', true)->get();
        $payments = Payment::with(['plan', 'method'])
            ->where('member_id', $member->id)
            ->latest()
            ->get();

        return view('member.subscriptions.index', compact('member', 'plans', 'methods', 'payments'));
    }

// Tampilkan form upload bukti untuk paket tertentu
    public function pay(SubscriptionPlan $plan)
    {
        $member = Auth::guard('member')->user();
        $methods = PaymentMethod::where('is_active', true)->get();

        // Setting: apakah QR code ditampilkan atau tidak
        $qrEnabled = (bool) \App\Models\Setting::get('qr_enabled', true);

        return view('member.subscriptions.pay', compact('member', 'plan', 'methods', 'qrEnabled'));
    }

    // Simpan pembayaran (status pending)
    public function store(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'payment_proof'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $member = Auth::guard('member')->user();
        $method = PaymentMethod::findOrFail($request->payment_method_id);

        // Simpan bukti pembayaran di storage/app/public/payments
        $path = $request->file('payment_proof')->store('payments', 'public');

        Payment::create([
            'member_id'           => $member->id,
            'subscription_plan_id'=> $plan->id,
            'payment_method_id'   => $method->id,
            'amount'              => $plan->price,
            'payment_proof'       => $path,
            'status'              => 'pending',
        ]);

        return redirect()->route('member.subscriptions.index')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}
