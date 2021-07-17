<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class OperatorEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $operator = Operator::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($operator, 'operator')->get('operator/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $operator = Operator::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'operator.verification.verify',
            now()->addMinutes(60),
            ['id' => $operator->id, 'hash' => sha1($operator->email)]
        );

        $response = $this->actingAs($operator, 'operator')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($operator->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('operator.dashboard').'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $operator = Operator::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'operator.verification.verify',
            now()->addMinutes(60),
            ['id' => $operator->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($operator, 'operator')->get($verificationUrl);

        $this->assertFalse($operator->fresh()->hasVerifiedEmail());
    }
}
