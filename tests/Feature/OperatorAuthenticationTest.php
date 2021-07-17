<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperatorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('operator/login');

        $response->assertStatus(200);
    }

    public function test_operators_can_authenticate_using_the_login_screen()
    {
        $operator = Operator::factory()->create();

        $response = $this->post('operator/login', [
            'email' => $operator->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('operator');
        $response->assertRedirect(route('operator.dashboard'));
    }

    public function test_operators_can_not_authenticate_with_invalid_password()
    {
        $operator = Operator::factory()->create();

        $this->post('operator/login', [
            'email' => $operator->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('operator');
    }
}
