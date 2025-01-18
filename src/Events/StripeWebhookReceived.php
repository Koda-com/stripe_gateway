<?php

namespace kodastripe\StripeWebhook\Events;

class StripeWebhookReceived
{
    public $webhookEvent;

    /**
     * Cria uma nova instância de evento.
     */
    public function __construct($webhookEvent)
    {
        $this->webhookEvent = $webhookEvent;
    }
}