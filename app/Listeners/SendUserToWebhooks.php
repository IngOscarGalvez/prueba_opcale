<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Spatie\WebhookServer\WebhookCall;
use App\Models\Webhook;
use Illuminate\Support\Facades\Log;

class SendUserToWebhooks
{
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        $webhooks = Webhook::all();

        Log::info('UserCreated event handled', ['user' => $user->id]);

        foreach ($webhooks as $webhook) {
            $url = $webhook->url ?? env('WEBHOOK_URL');

            Log::info('Sending webhook', [
                'url' => $url,
                'method' => $webhook->method,
                'headers' => $webhook->headers,
                'payload' => ['user' => $user]
            ]);

            WebhookCall::create()
                ->url($url)
                ->payload(['user' => $user])
                ->withHeaders(json_decode($webhook->headers, true) ?? [])
                ->useSecret(env('WEBHOOK_SECRET')) // Añadir el secreto
                ->dispatch();
        }
    }
}
