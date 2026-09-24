<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that the collector registration page is available.
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Check that a new collector can register successfully.
     */
    public function test_new_collectors_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'hotwheelscollector',
            'email' => 'collector@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'username' => 'hotwheelscollector',
            'email' => 'collector@example.com',
            'role' => 'collector',
        ]);
    }

    /**
     * Verify that passwords shorter than eight characters are rejected.
     */
    public function test_password_must_be_at_least_eight_characters(): void
    {
        $response = $this->post('/register', [
            'username' => 'collector1',
            'email' => 'collector1@example.com',
            'password' => 'Pass12',
            'password_confirmation' => 'Pass12',
        ]);

        $response->assertSessionHasErrors('password');

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'collector1@example.com',
        ]);
    }

    /**
     * Verify that the same email address cannot be registered twice.
     */
    public function test_email_address_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'used@example.com',
        ]);

        $response = $this->post('/register', [
            'username' => 'collector2',
            'email' => 'used@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();

        $this->assertSame(
            1,
            User::where('email', 'used@example.com')->count()
        );
    }

    /**
     * Verify that public registration creates collector accounts.
     */
    public function test_registered_user_receives_collector_role(): void
    {
        $this->post('/register', [
            'username' => 'collector3',
            'email' => 'collector3@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'collector3@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('collector', $user->role);
        $this->assertFalse($user->isAdministrator());
    }
}