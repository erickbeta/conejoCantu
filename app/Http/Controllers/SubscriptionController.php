<?php

namespace App\Http\Controllers;

use App\Mail\ThankYouMail;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function subscribe($plan)
    {
        $settings = Setting::all()->keyBy('key');

        switch (strtolower($plan)) {
            case 'oro':
                $price = $settings['club_oro_price']->value ?? 188;
                $planName = 'Club Oro';
                $reason = 'Suscripción Mensual Club Oro - Conejo Cantú';
                break;
            case 'titanio':
                $price = $settings['club_titanio_price']->value ?? 788;
                $planName = 'Club Titanio';
                $reason = 'Suscripción Mensual Club Titanio - Conejo Cantú';
                break;
            case 'elite':
                $price = $settings['club_elite_price']->value ?? 1888;
                $planName = 'Club Elite';
                $reason = 'Suscripción Mensual Club Elite - Conejo Cantú';
                break;
            default:
                return redirect()->back()->with('error', 'Plan no válido.');
        }

        return $this->initiateCheckout($planName, $reason, (float) $price, true);
    }

    public function donate(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:188']);
        $amount = (float) $request->amount;

        return $this->initiateCheckout(
            'Aportación Única',
            'Aportación Libre - Conejo Cantú',
            $amount,
            false
        );
    }

    public function donateRecurring(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:2888']);
        $amount = (float) $request->amount;

        return $this->initiateCheckout(
            'Club Diamante',
            'Suscripción Mensual Club Diamante - Conejo Cantú',
            $amount,
            true
        );
    }

    protected function initiateCheckout(string $planName, string $reason, float $amount, bool $isRecurring)
    {
        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if (! $token) {
            return redirect()->back()->with('error', 'Error de configuración: Faltan credenciales de pago.');
        }

        $user = Auth::user();
        $claimToken = Str::random(40);

        $subscription = Subscription::create([
            'user_id' => $user?->id,
            'payer_email' => $user?->email,
            'claim_token' => $claimToken,
            'plan_name' => $planName,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Guardar solo en sesión temporal mientras va a Mercado Pago (la cookie se crea únicamente si el pago es aprobado)
        session(['pending_subscription_token' => $claimToken]);

        $baseUrl = rtrim(config('app.url', 'https://conejocantu.com'), '/');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1') || str_contains($baseUrl, '192.168')) {
            $baseUrl = 'https://conejocantu.com';
        }

        $callbackUrl = $baseUrl . '/payment/callback?token=' . $claimToken;
        $failureUrl = $baseUrl . '/#suscripciones';

        // Si el usuario ya tiene sesión y es recurrente, intentar preapproval primero
        if ($isRecurring && $user && $user->email) {
            $preapprovalResponse = Http::withToken($token)->post('https://api.mercadopago.com/preapproval', [
                'reason' => $reason,
                'external_reference' => $claimToken,
                'payer_email' => $user->email,
                'auto_recurring' => [
                    'frequency' => 1,
                    'frequency_type' => 'months',
                    'transaction_amount' => $amount,
                    'currency_id' => 'MXN',
                ],
                'back_url' => $callbackUrl,
                'status' => 'pending',
            ]);

            if ($preapprovalResponse->successful()) {
                $data = $preapprovalResponse->json();
                if (! empty($data['id'])) {
                    $subscription->update(['mercadopago_id' => (string) $data['id']]);
                }
                if (! empty($data['init_point'])) {
                    return redirect()->away($data['init_point']);
                }
            }
        }

        // Flujo universal (invitados y usuarios): Checkout Pro Preference
        $preferenceData = [
            'items' => [
                [
                    'title' => $reason,
                    'quantity' => 1,
                    'unit_price' => $amount,
                    'currency_id' => 'MXN',
                ],
            ],
            'external_reference' => $claimToken,
            'back_urls' => [
                'success' => $callbackUrl,
                'failure' => $failureUrl,
                'pending' => $callbackUrl,
            ],
            'auto_return' => 'approved',
        ];

        if ($user && $user->email) {
            $preferenceData['payer'] = ['email' => $user->email];
        }

        $response = Http::withToken($token)->post('https://api.mercadopago.com/checkout/preferences', $preferenceData);

        if ($response->successful()) {
            $data = $response->json();
            return redirect()->away($data['init_point']);
        }

        $errorDetail = $response->body();
        Log::error('MercadoPago Checkout Error: ' . $errorDetail);

        return redirect()->back()->with('error', 'Hubo un error al conectar con Mercado Pago. Intenta nuevamente.');
    }

    public function handleCallback(Request $request)
    {
        $claimToken = $request->query('token')
            ?? $request->query('external_reference')
            ?? session('pending_subscription_token')
            ?? session('claim_subscription_token')
            ?? $request->cookie('claim_subscription_token');

        $paymentId = $request->query('payment_id') ?? $request->query('collection_id');
        $preapprovalId = $request->query('preapproval_id');
        $mpStatus = $request->query('status') ?? $request->query('collection_status');

        $subscription = null;
        if ($claimToken) {
            $subscription = Subscription::where('claim_token', $claimToken)->first();
        }
        if (! $subscription && $preapprovalId) {
            $subscription = Subscription::where('mercadopago_id', $preapprovalId)->first();
        }
        if (! $subscription && $paymentId) {
            $subscription = Subscription::where('mercadopago_id', $paymentId)->first();
        }

        if (! $subscription) {
            return redirect('/#suscripciones')->with('error', 'No se encontró la referencia del pago.');
        }

        // Si el pago ya había sido reclamado por un usuario anteriormente (ej. recarga accidental)
        if ($subscription->user_id) {
            if (Auth::check()) {
                return redirect()->route('dashboard')->with('success', 'Tu membresía ' . $subscription->plan_name . ' ya se encuentra activa.');
            }
            return redirect()->route('login')->with('status', 'Tu pago ya fue vinculado a tu cuenta. Inicia sesión para acceder a tu panel.');
        }

        if (in_array($mpStatus, ['rejected', 'cancelled', 'failure', 'null'], true)) {
            $subscription->update(['status' => 'cancelled']);
            return redirect('/#suscripciones')->with('error', 'El pago no fue completado o fue rechazado.');
        }

        $token = env('MERCADOPAGO_ACCESS_TOKEN');
        $payerEmail = $subscription->payer_email;
        $verifiedMpId = $paymentId ?? $preapprovalId ?? $subscription->mercadopago_id;

        if ($token && $paymentId) {
            $res = Http::withToken($token)->get("https://api.mercadopago.com/v1/payments/{$paymentId}");
            if ($res->successful()) {
                $paymentData = $res->json();
                $mpStatus = $paymentData['status'] ?? $mpStatus;
                $payerEmail = $paymentData['payer']['email'] ?? $payerEmail;
            }
        } elseif ($token && $preapprovalId) {
            $res = Http::withToken($token)->get("https://api.mercadopago.com/preapproval/{$preapprovalId}");
            if ($res->successful()) {
                $preData = $res->json();
                $mpStatus = $preData['status'] ?? $mpStatus;
                $payerEmail = $preData['payer_email'] ?? $payerEmail;
            }
        }

        if (! in_array($mpStatus, ['approved', 'authorized'], true) && $subscription->status !== 'active') {
            $subscription->update(['status' => 'cancelled']);
            session()->forget(['pending_subscription_token', 'claim_subscription_token']);
            Cookie::queue(Cookie::forget('claim_subscription_token'));
            return redirect('/#suscripciones')->with('error', 'El pago no fue completado en Mercado Pago.');
        }

        $wasAlreadyActive = $subscription->status === 'active';

        $subscription->update([
            'mercadopago_id' => $verifiedMpId ? (string) $verifiedMpId : $subscription->mercadopago_id,
            'payer_email' => $payerEmail,
            'status' => 'active',
            'expires_at' => $subscription->expires_at ?? now()->addMonth(),
        ]);

        // Si el usuario ya está autenticado, ligamos el pago a su cuenta directamente
        if (Auth::check()) {
            $user = Auth::user();
            $subscription->update(['user_id' => $user->id]);
            session()->forget(['pending_subscription_token', 'claim_subscription_token']);
            Cookie::queue(Cookie::forget('claim_subscription_token'));

            if (! $wasAlreadyActive) {
                try {
                    Mail::to($user->email)->send(new ThankYouMail([
                        'name' => $user->name,
                        'plan' => $subscription->plan_name,
                        'is_subscription' => $subscription->plan_name !== 'Aportación Única',
                    ]));
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de confirmación: ' . $e->getMessage());
                }
            }

            return redirect()->route('dashboard')->with('success', '¡Pago confirmado! Tu membresía ' . $subscription->plan_name . ' ya está activa.');
        }

        // Si el usuario no tiene cuenta aún: guardar en sesión y en cookie de 30 días
        session(['claim_subscription_token' => $subscription->claim_token]);
        Cookie::queue('claim_subscription_token', $subscription->claim_token, 60 * 24 * 30);

        // Enviar correo de respaldo al pagador con el enlace directo de registro por si cierra la página
        if (! $wasAlreadyActive && $payerEmail) {
            try {
                Mail::to($payerEmail)->send(new ThankYouMail([
                    'name' => 'Nuevo Miembro Conejo Club',
                    'plan' => $subscription->plan_name,
                    'is_subscription' => true,
                    'claim_url' => route('register', ['payment_token' => $subscription->claim_token]),
                ]));
            } catch (\Exception $e) {
                Log::error('Error enviando correo con enlace de activación: ' . $e->getMessage());
            }
        }

        return redirect()->route('register', ['payment_token' => $subscription->claim_token]);
    }

    /**
     * Permite a un usuario ya registrado reclamar/vincular manualmente su pago
     * usando su número de operación de Mercado Pago, correo de pago o código.
     */
    public function claimPayment(Request $request)
    {
        $request->validate([
            'reference' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $reference = trim($request->input('reference'));

        // 1. Buscar en nuestra tabla de suscripciones no vinculadas
        $subscription = Subscription::whereNull('user_id')
            ->where(function ($query) use ($reference) {
                $query->where('mercadopago_id', $reference)
                    ->orWhere('claim_token', $reference)
                    ->orWhere('payer_email', $reference);
            })
            ->latest()
            ->first();

        if ($subscription) {
            $subscription->update([
                'user_id' => $user->id,
                'status' => 'active',
                'expires_at' => $subscription->expires_at ?? now()->addMonth(),
            ]);

            session()->forget(['pending_subscription_token', 'claim_subscription_token']);
            Cookie::queue(Cookie::forget('claim_subscription_token'));

            return redirect()->route('dashboard')->with('success', '¡Pago encontrado y vinculado con éxito! Tu membresía ' . $subscription->plan_name . ' está activa.');
        }

        // 2. Si ingresó un ID numérico de operación de Mercado Pago, verificar en vivo en la API de Mercado Pago
        $token = env('MERCADOPAGO_ACCESS_TOKEN');
        if ($token && is_numeric($reference)) {
            $res = Http::withToken($token)->get("https://api.mercadopago.com/v1/payments/{$reference}");
            if ($res->successful()) {
                $paymentData = $res->json();
                $status = $paymentData['status'] ?? '';
                $externalRef = $paymentData['external_reference'] ?? null;
                $description = $paymentData['description'] ?? '';

                if ($status === 'approved') {
                    // Verificar que este ID de pago no pertenezca ya a otro usuario
                    $alreadyClaimed = Subscription::where('mercadopago_id', (string) $reference)
                        ->whereNotNull('user_id')
                        ->exists();

                    if ($alreadyClaimed) {
                        return redirect()->back()->with('error', 'Este número de pago ya fue vinculado a una cuenta anteriormente.');
                    }

                    $planName = 'Club Oro';
                    if (str_contains(strtolower($description), 'titanio')) $planName = 'Club Titanio';
                    if (str_contains(strtolower($description), 'elite')) $planName = 'Club Elite';
                    if (str_contains(strtolower($description), 'diamante')) $planName = 'Club Diamante';

                    $sub = $externalRef ? Subscription::where('claim_token', $externalRef)->first() : null;

                    if ($sub) {
                        $sub->update([
                            'user_id' => $user->id,
                            'mercadopago_id' => (string) $reference,
                            'status' => 'active',
                            'expires_at' => now()->addMonth(),
                        ]);
                    } else {
                        Subscription::create([
                            'user_id' => $user->id,
                            'payer_email' => $paymentData['payer']['email'] ?? $user->email,
                            'mercadopago_id' => (string) $reference,
                            'plan_name' => $planName,
                            'amount' => $paymentData['transaction_amount'] ?? null,
                            'status' => 'active',
                            'expires_at' => now()->addMonth(),
                        ]);
                    }

                    return redirect()->route('dashboard')->with('success', '¡Pago verificado en Mercado Pago y vinculado con éxito!');
                }
            }
        }

        return redirect()->back()->with('error', 'No encontramos ningún pago pendiente de vincular con ese dato. Verifica tu número de operación de Mercado Pago o el correo con el que realizaste el pago.');
    }
}
