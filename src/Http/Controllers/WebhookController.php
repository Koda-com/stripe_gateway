<?php

namespace kodastripe\StripeWebhook\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\StripeWebhookReceived;
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
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('stripewebhook.secret', env('STRIPE_WEBHOOK_SECRET'));

        return Webhook::constructEvent($payload, $sigHeader, $secret);
    }
}