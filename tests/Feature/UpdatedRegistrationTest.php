<?php

use App\Models\User;

test('users can register with all required fields', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+1234567890',
        'country' => 'US',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'terms' => '1',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->name)->toBe('Test User');
    expect($user->phone)->toBe('+1234567890');
    expect($user->country)->toBe('US');
});

test('registration requires all fields', function () {
    $response = $this->post('/register', []);

    $response->assertSessionHasErrors(['name', 'email', 'phone', 'country', 'password', 'terms']);
});

test('registration requires valid email', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'phone' => '+1234567890',
        'country' => 'US',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'terms' => '1',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('registration requires password confirmation', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+1234567890',
        'country' => 'US',
        'password' => 'Password123!',
        'password_confirmation' => 'DifferentPassword',
        'terms' => '1',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('registration requires terms acceptance', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+1234567890',
        'country' => 'US',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasErrors(['terms']);
});
