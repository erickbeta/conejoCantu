<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $token = $request->input('payment_token')
            ?? session('claim_subscription_token')
            ?? $request->cookie('claim_subscription_token')
            ?? session('pending_subscription_token');

        $request->session()->regenerate();

        $user = $request->user();
        $subscription = null;

        if (! $user->isAdmin()) {
            if ($token) {
                $subscription = \App\Models\Subscription::where('claim_token', $token)
                    ->whereNull('user_id')
                    ->where('status', 'active')
                    ->first();
            }

            if (! $subscription) {
                $subscription = \App\Models\Subscription::where('payer_email', $user->email)
                    ->whereNull('user_id')
                    ->where('status', 'active')
                    ->latest()
                    ->first();
            }

            if ($subscription) {
                $subscription->update([
                    'user_id' => $user->id,
                    'status' => 'active',
                    'expires_at' => $subscription->expires_at ?? now()->addMonth(),
                ]);
                session()->forget(['claim_subscription_token', 'pending_subscription_token']);
                \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('claim_subscription_token'));
            }
        }

        if ($request->user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
