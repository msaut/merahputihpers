<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class AdminSubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->paginate(15);
        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'days'        => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        SubscriptionPlan::create($request->only(['name', 'days', 'price', 'description']) + ['is_active' => true]);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'days'        => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $subscriptionPlan->update($request->only(['name', 'days', 'price', 'description', 'is_active']));

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();
        return back()->with('success', 'Paket berhasil dihapus.');
    }
}
