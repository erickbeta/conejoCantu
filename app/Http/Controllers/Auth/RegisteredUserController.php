<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ThankYouMail;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $token = $request->query('payment_token')
            ?? session('claim_subscription_token')
            ?? $request->cookie('claim_subscription_token')
            ?? session('pending_subscription_token');
        $pendingSubscription = null;

        if ($token) {
            $pendingSubscription = Subscription::where('claim_token', $token)
                ->whereNull('user_id')
                ->where('status', 'active')
                ->first();

            if (! $pendingSubscription) {
                Cookie::queue(Cookie::forget('claim_subscription_token'));
                session()->forget(['claim_subscription_token', 'pending_subscription_token']);
            }
        }

        return view('auth.register', compact('pendingSubscription'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birthdate' => ['nullable', 'date'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        // Vincular el pago realizado con el nuevo usuario
        $token = $request->input('payment_token')
            ?? session('claim_subscription_token')
            ?? $request->cookie('claim_subscription_token')
            ?? session('pending_subscription_token');
        $subscription = null;

        if ($token) {
            $subscription = Subscription::where('claim_token', $token)
                ->whereNull('user_id')
                ->where('status', 'active')
                ->first();
        }

        if (! $subscription) {
            $subscription = Subscription::where('payer_email', $user->email)
                ->whereNull('user_id')
                ->where('status', 'active')
                ->latest()
                ->first();
        }

        if ($subscription) {
            $subscription->update([
                'user_id' => $user->id,
                'payer_email' => $subscription->payer_email ?? $user->email,
                'status' => 'active',
                'expires_at' => $subscription->expires_at ?? now()->addMonth(),
            ]);

            session()->forget(['claim_subscription_token', 'pending_subscription_token']);
            Cookie::queue(Cookie::forget('claim_subscription_token'));

            try {
                Mail::to($user->email)->send(new ThankYouMail([
                    'name' => $user->name,
                    'plan' => $subscription->plan_name,
                    'is_subscription' => $subscription->plan_name !== 'Aportación Única',
                ]));
            } catch (\Exception $e) {
                Log::error('Error enviando correo de bienvenida tras registro: ' . $e->getMessage());
            }
        }

        event(new Registered($user));

        Auth::login($user);

        if ($subscription) {
            return redirect(route('dashboard', absolute: false))
                ->with('success', '¡Cuenta creada y vinculada con éxito a tu membresía ' . $subscription->plan_name . '!');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
