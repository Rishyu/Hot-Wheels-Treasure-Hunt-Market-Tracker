<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify that a collector can change their password.
     */
    public function test_collector_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        Livewire::test('pages::settings.security')
            ->set('current_password', 'oldpassword')
            ->set('password', 'newpassword123')
            ->set('password_confirmation', 'newpassword123')
            ->call('updatePassword')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertTrue(
            Hash::check('newpassword123', $user->password)
        );
    }

    /**
     * Verify that the current password is required before changing it.
     */
    public function test_correct_current_password_is_required(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        Livewire::test('pages::settings.security')
            ->set('current_password', 'wrongpassword')
            ->set('password', 'newpassword123')
            ->set('password_confirmation', 'newpassword123')
            ->call('updatePassword')
            ->assertHasErrors(['current_password']);
    }

    /**
     * Verify that the new password must be confirmed.
     */
    public function test_new_password_must_be_confirmed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        Livewire::test('pages::settings.security')
            ->set('current_password', 'oldpassword')
            ->set('password', 'newpassword123')
            ->set('password_confirmation', 'differentpassword')
            ->call('updatePassword')
            ->assertHasErrors(['password']);
    }
}