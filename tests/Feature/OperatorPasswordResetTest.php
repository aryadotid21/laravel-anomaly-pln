<?php

namespace Tests\Feature;

use App\Models\Operator;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OperatorPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('operator/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $operator = Operator::factory()->create();

        $response = $this->post('operator/forgot-password', [
            'email' => $operator->email,
        ]);

        Notification::assertSentTo($operator, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $operator = Operator::factory()->create();

        $response = $this->post('operator/forgot-password', [
            'email' => $operator->email,
        ]);

        Notification::assertSentTo($operator, ResetPassword::class, function ($notification) {
            $response = $this->get('operator/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $operator = Operator::factory()->create();

        $response = $this->post('operator/forgot-password', [
            'email' => $operator->email,
        ]);

        Notification::assertSentTo($operator, ResetPassword::class, function ($notification) use ($operator) {
            $response = $this->post('operator/reset-password', [
                'token' => $notification->token,
                'email' => $operator->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
