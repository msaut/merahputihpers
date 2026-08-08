<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->paginate(15);
        return view('admin.payment-methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment-methods.create');
    }

    public function store(Request $request)
    {
$request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'code'           => ['required', 'string', 'max:50', 'unique:payment_methods,code'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'account_name'   => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
        ]);

        PaymentMethod::create($request->only(['name', 'code', 'account_number', 'account_name', 'description']) + ['is_active' => true]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
$request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'code'           => ['required', 'string', 'max:50', 'unique:payment_methods,code,' . $paymentMethod->id],
            'account_number' => ['nullable', 'string', 'max:255'],
            'account_name'   => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        $paymentMethod->update($request->only(['name', 'code', 'account_number', 'account_name', 'description', 'is_active']));

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
