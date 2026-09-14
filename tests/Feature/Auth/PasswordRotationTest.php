<?php

use App\Models\User;
use Livewire\Livewire;

test('a user with a start password is forced to the rotation page', function () {
    $user = User::factory()->create(['must_change_password' => true]);

    $this->actingAs($user)->get(route('dashboard'))->assertRedirect(route('password.rotate'));
    $this->actingAs($user)->get(route('learn.index'))->assertRedirect(route('password.rotate'));
    $this->actingAs($user)->get(route('password.rotate'))->assertOk()->assertSee('Neues Passwort festlegen');
});

test('users without the flag are not affected', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
    $this->actingAs($user)->get(route('password.rotate'))->assertRedirect(route('dashboard'));
});

test('rotating the password clears the flag and lets the user in', function () {
    $user = User::factory()->create(['must_change_password' => true]);

    Livewire::actingAs($user)
        ->test('pages::settings.rotate-password')
        ->set('current_password', 'password')
        ->set('password', 'Neues-Passwort-2026')
        ->set('password_confirmation', 'Neues-Passwort-2026')
        ->call('rotate')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect($user->fresh()->must_change_password)->toBeFalse();
    $this->actingAs($user->fresh())->get(route('dashboard'))->assertOk();
});

test('the new password must differ from the start password and match the confirmation', function () {
    $user = User::factory()->create(['must_change_password' => true]);

    Livewire::actingAs($user)
        ->test('pages::settings.rotate-password')
        ->set('current_password', 'password')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('rotate')
        ->assertHasErrors(['password']);

    Livewire::actingAs($user)
        ->test('pages::settings.rotate-password')
        ->set('current_password', 'falsch')
        ->set('password', 'Neues-Passwort-2026')
        ->set('password_confirmation', 'Neues-Passwort-2026')
        ->call('rotate')
        ->assertHasErrors(['current_password']);

    expect($user->fresh()->must_change_password)->toBeTrue();
});
