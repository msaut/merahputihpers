<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberIsActive
{
    // Pastikan member sudah login dan langganannya aktif.
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('member')->check()) {
            return redirect()->route('member.login');
        }

        $member = Auth::guard('member')->user();

        // Jika langganan expired, perbarui status menjadi inactive
        if ($member->status === 'active' && $member->subscription_end && $member->subscription_end->isPast()) {
            $member->status = 'inactive';
            $member->save();
        }

        if (!$member->isActive()) {
            return redirect()->route('member.subscriptions.index')
                ->with('error', 'Anda belum memiliki langganan aktif. Silakan pilih paket untuk mengakses koran digital.');
        }

        return $next($request);
    }
}
