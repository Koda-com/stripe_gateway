<?php

return [
    'prefix' => 'webhooks',
    'middleware' => ['api'],
    'secret' => env('STRIPE_WEBHOOK_SECRET'),
];