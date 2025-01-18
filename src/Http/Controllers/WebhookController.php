<?php

namespace kodastripe\StripeWebhook\Http\Controllers;

use Illuminate\Http\Request;
use kodastripe\StripeWebhook\Events\StripeWebhookReceived;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class WebhookController
{
    public function handle(Request $request)
    {
        $webhookEvent = $this->verifySignature($request);

        event(new StripeWebhookReceived($webhookEvent));

        return response()->json(['status' => 'success']);
    }

    /**
     * Verifica a assinatura do webhook.
     *
     * @param Request $request
     * 
     * @return \Stripe\Event
     * @throws SignatureVerificationException
     */
    private function verifySignature(Request $request)
    {
        try {
            $payload = $request->getContent();
            $sigHeader = $request->header('Stripe-Signature');
            $secret = config('stripewebhook.secret', env('STRIPE_WEBHOOK_SECRET'));
    
            return Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $exception) {
            Log::error('Falha ao receber WebHook - Verificação da assinatura falhou');
            Log::error($exception->getMessage());
        }
    }
}