<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperatorRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('operator/register');

        $response->assertStatus(200);
    }

    public function test_new_operators_can_register()
    {
        $response = $this->post('operator/register', [
            'name' => 'Test Operator',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('operator');
        $response->assertRedirect(route('operator.dashboard'));
    }
}
