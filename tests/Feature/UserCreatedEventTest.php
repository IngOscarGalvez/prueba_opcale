<?php

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserCreatedEventTest extends TestCase
{
    /** @test */
    public function it_dispatches_user_created_event()
    {
        Event::fake();

        $user = User::factory()->create();

        Event::assertDispatched(UserCreated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }
}
