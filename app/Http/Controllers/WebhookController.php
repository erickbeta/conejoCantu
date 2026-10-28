<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouMail;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $type = $request->input('type') ?? $request->input('topic');
        $id = $request->input('data.id') ?? $request->input('id');
        
        Log::info('Mercado Pago Webhook Received:', ['type' => $type, 'id' => $id]);

        if (!$id) {
            return response()->json(['status' => 'ignored']);
        }

        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if ($type === 'subscription_preapproval' || $type === 'preapproval') {
            $response = Http::withToken($token)->get("https://api.mercadopago.com/preapproval/{$id}");
            
            if ($response->successful()) {
                $data = $response->json();
                $externalRef = $data['external_reference'] ?? null;
                $status = $data['status'] ?? ''; // authorized, paused, cancelled
                $reason = $data['reason'] ?? '';
                $payerEmail = $data['payer_email'] ?? null;

                $planName = 'Club Oro';
                if (str_contains(strtolower($reason), 'oro')) $planName = 'Club Oro';
                if (str_contains(strtolower($reason), 'titanio')) $planName = 'Club Titanio';
                if (str_contains(strtolower($reason), 'elite')) $planName = 'Club Elite';
                if (str_contains(strtolower($reason), 'diamante')) $planName = 'Club Diamante';

                $subscription = null;
                if ($externalRef) {
                    $subscription = Subscription::where('claim_token', $externalRef)->first();
                }

                if ($subscription) {
                    $subscription->update([
                        'mercadopago_id' => (string) $id,
                        'payer_email' => $payerEmail ?? $subscription->payer_email,
                        'plan_name' => $planName,
                        'status' => $status === 'authorized' ? 'active' : 'cancelled',
                        'expires_at' => $status === 'authorized' ? now()->addMonth() : $subscription->expires_at,
                    ]);
                    $user = $subscription->user;
                } else {
                    $user = $externalRef && is_numeric($externalRef) ? User::find($externalRef) : null;
                    if ($user) {
                        $subscription = Subscription::updateOrCreate(
                            ['user_id' => $user->id],
                            [
                                'mercadopago_id' => (string) $id,
                                'payer_email' => $payerEmail ?? $user->email,
                                'plan_name' => $planName,
                                'status' => $status === 'authorized' ? 'active' : 'cancelled',
                                'expires_at' => $status === 'authorized' ? now()->addMonth() : null,
                            ]
                        );
                    }
                }

                if ($status === 'authorized' && isset($user) && $user) {
                    try {
                        Mail::to($user->email)->send(new ThankYouMail([
                            'name' => $user->name,
                            'plan' => $planName,
                            'is_subscription' => true,
                        ]));
                    } catch (\Exception $e) {
                        Log::error('Error enviando email de bienvenida: ' . $e->getMessage());
                    }
                }
            }
        } elseif ($type === 'payment') {
            $response = Http::withToken($token)->get("https://api.mercadopago.com/v1/payments/{$id}");
            
            if ($response->successful()) {
                $data = $response->json();
                $status = $data['status'] ?? '';
                $payerEmail = $data['payer']['email'] ?? null;
                $description = $data['description'] ?? 'Aportación';
                $externalRef = $data['external_reference'] ?? null;

                $subscription = null;
                if ($externalRef) {
                    $subscription = Subscription::where('claim_token', $externalRef)->first();
                }

                if ($subscription && $status === 'approved') {
                    $subscription->update([
                        'mercadopago_id' => (string) $id,
                        'payer_email' => $payerEmail ?? $subscription->payer_email,
                        'status' => 'active',
                        'expires_at' => $subscription->expires_at ?? now()->addMonth(),
                    ]);
                }
                
                if ($status === 'approved' && $payerEmail) {
                    try {
                        $mailData = [
                            'name' => $subscription?->user?->name ?? 'Amigo/a',
                            'plan' => $subscription?->plan_name ?? $description,
                            'is_subscription' => ! str_contains(strtolower($description), 'libre'),
                        ];
                        if ($subscription && ! $subscription->user_id) {
                            $mailData['claim_url'] = route('register', ['payment_token' => $subscription->claim_token]);
                        }
                        Mail::to($payerEmail)->send(new ThankYouMail($mailData));
                    } catch (\Exception $e) {
                        Log::error('Error enviando email de pago: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
