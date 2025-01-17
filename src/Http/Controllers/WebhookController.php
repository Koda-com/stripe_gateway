<?php

namespace kodastripe\StripeWebhook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController
{
    public function handle(Request $request)
    {
        // Verifique a assinatura do webhook (opcional, mas recomendado)
        $this->verifySignature($request);

        // Processar o evento
        $event = $request->input('type');
        switch ($event) {
            case 'invoice.paid':
                $this->handlePaymentSucceeded($request->input('data.object'));
                break;
            case 'invoice.payment_failed':
                $this->handlePaymentFailed($request->input('data.object'));
                break;
            default:
                Log::info("Evento desconhecido recebido: {$event}");
        }

        return response()->json(['status' => 'success']);
    }

    protected function verifySignature(Request $request)
    {
        // Implementar verificação de assinatura usando a biblioteca oficial do Stripe
    }

    protected function handlePaymentSucceeded($data)
    {
        Log::info('Pagamento bem-sucedido!', ['data' => $data]);
    }

    protected function handlePaymentFailed($data)
    {
        Log::warning('Pagamento falhou!', ['data' => $data]);
    }
}