<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_a_register_form()
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    public function test_user_cannot_view_a_register_form_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/panel');
    }

    public function test_user_can_register_with_correct_data()
    {
       $user = [
            'name' => 'Lurline Turcotte',
            'email' => 'hhayes@example.com',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-laravel',
        ];

        $response = $this->from('/register')->post('/register', $user);

        $response->assertRedirect('/panel');

        array_splice($user,2, 2);

        $this->assertDatabaseHas('users', $user);
    }

    public function test_user_cannot_register_without_password_confirmation()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Lurline Turcotte',
            'email' => 'hhayes@example.com',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'wrong',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
