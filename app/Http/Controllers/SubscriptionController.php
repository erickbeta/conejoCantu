<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class SubscriptionController extends Controller
{
    public function subscribe($plan)
    {
        $user = Auth::user();
        
        // Determinar precio y nombre basado en el plan elegido
        $price = 0;
        $planName = '';
        $reason = '';
        
        $settings = Setting::all()->keyBy('key');

        switch(strtolower($plan)) {
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
                $price = $settings['club_elite_price']->value ?? 2500;
                $planName = 'Club Elite';
                $reason = 'Suscripción Mensual Club Elite - Conejo Cantú';
                break;
            default:
                return redirect()->back()->with('error', 'Plan no válido.');
        }

        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if (!$token) {
            return redirect()->back()->with('error', 'Error de configuración: Faltan credenciales de pago.');
        }

        // Crear la preaprobación (suscripción) en Mercado Pago
        $baseUrl = config('app.url', 'https://conejocantu.com');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '192.168')) {
            $baseUrl = 'https://conejocantu.com';
        }

        $response = Http::withToken($token)->post('https://api.mercadopago.com/preapproval', [
            'reason' => $reason,
            'external_reference' => (string) $user->id,
            'payer_email' => $user->email,
            'auto_recurring' => [
                'frequency' => 1,
                'frequency_type' => 'months',
                'transaction_amount' => (float) $price,
                'currency_id' => 'MXN',
            ],
            'back_url' => $baseUrl . '/dashboard',
            'status' => 'pending',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return redirect()->away($data['init_point']);
        }

        return redirect()->back()->with('error', 'Hubo un error al conectar con Mercado Pago. Intenta nuevamente.');
    }

    public function donate(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:188']);
        $amount = (float) $request->amount;
        $user = Auth::user();

        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if (!$token) {
            return redirect()->back()->with('error', 'Error de configuración: Faltan credenciales de pago.');
        }

        $baseUrl = config('app.url', 'https://conejocantu.com');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '192.168')) {
            // Mercado Pago a veces rechaza IPs locales en back_urls
            $baseUrl = 'https://conejocantu.com';
        }

        $preferenceData = [
            'items' => [
                [
                    'title' => 'Aportación Libre - Conejo Cantú',
                    'quantity' => 1,
                    'unit_price' => $amount,
                    'currency_id' => 'MXN',
                ]
            ],
            'back_urls' => [
                'success' => $baseUrl,
                'failure' => $baseUrl,
                'pending' => $baseUrl
            ],
            'auto_return' => 'approved',
        ];

        if ($user) {
            $preferenceData['payer'] = ['email' => $user->email];
            $preferenceData['external_reference'] = 'DONATION_' . $user->id;
        }

        $response = Http::withToken($token)->post('https://api.mercadopago.com/checkout/preferences', $preferenceData);

        if ($response->successful()) {
            $data = $response->json();
            return redirect()->away($data['init_point']);
        }

        // Return exact error for debugging
        $errorDetail = $response->body();
        \Illuminate\Support\Facades\Log::error('MercadoPago Error: ' . $errorDetail);

        return redirect()->back()->with('error', 'Error de Mercado Pago: ' . $errorDetail);
    }

    public function donateRecurring(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:2888']);
        $amount = (float) $request->amount;
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Por favor inicia sesión o crea una cuenta para activar una suscripción mensual.');
        }

        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if (!$token) {
            return redirect()->back()->with('error', 'Error de configuración: Faltan credenciales de pago.');
        }

        $baseUrl = config('app.url', 'https://conejocantu.com');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '192.168')) {
            $baseUrl = 'https://conejocantu.com';
        }

        $response = Http::withToken($token)->post('https://api.mercadopago.com/preapproval', [
            'reason' => 'Aportación Mensual Libre - Conejo Cantú',
            'external_reference' => (string) $user->id,
            'payer_email' => $user->email,
            'auto_recurring' => [
                'frequency' => 1,
                'frequency_type' => 'months',
                'transaction_amount' => $amount,
                'currency_id' => 'MXN',
            ],
            'back_url' => $baseUrl,
            'status' => 'pending',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return redirect()->away($data['init_point']);
        }

        $errorDetail = $response->body();
        \Illuminate\Support\Facades\Log::error('MercadoPago Preapproval Error: ' . $errorDetail);

        return redirect()->back()->with('error', 'Error al crear suscripción en Mercado Pago: ' . $errorDetail);
    }
}
