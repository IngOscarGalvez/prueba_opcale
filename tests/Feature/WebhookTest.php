<?php
namespace Tests\Feature;

use App\Events\UserCreated;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    /** @test */
    public function it_sends_a_webhook_when_a_user_is_created()
    {
        Event::fake();
        Http::fake();

        $webhook = Webhook::create([
            'method' => 'POST',
            'url' => 'https://webhook.site/c8def935-38f2-4883-a78b-3d72cd686e6f',
            'headers' => json_encode(['Content-Type' => 'application/json']),
        ]);

        Log::info('Webhook created Test', ['webhook' => $webhook]);

        $user = User::factory()->create();

        Event::assertDispatched(UserCreated::class, function ($event) use ($user) {
            Log::info('UserCreated event dispatched', ['user' => $user->id]);
            return $event->user->is($user);
        });

    }
}


