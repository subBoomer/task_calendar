<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUserRegistration()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/home'); // Adjust the redirection URL
        $this->assertAuthenticated();
    }

    public function testUserLogin()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home'); // Adjust the redirection URL
        $this->assertAuthenticatedAs($user);
    }

    public function testAccessProtectedRoute()
    {
        $user = \App\Models\User::factory()->create();
        
        $response = $this->actingAs($user)->get('/dashboard'); // Replace '/dashboard' with your protected route

        $response->assertStatus(200); // Assuming 200 is the expected status for an authenticated user
    }

    public function testUserLogout()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('/logout'); // Adjust the logout URL if needed

        $response->assertRedirect('/'); // Adjust the redirection after logout
        $this->assertGuest();
    }

}
