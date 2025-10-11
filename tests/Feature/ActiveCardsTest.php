<?php

use App\Models\Card;
use App\Models\User;

test('user can count active cards correctly', function () {
    $user = User::factory()->create();

    // Create 3 active cards
    Card::factory()->active()->count(3)->create(['user_id' => $user->id]);

    // Create 2 frozen cards
    Card::factory()->frozen()->count(2)->create(['user_id' => $user->id]);

    // Create 1 terminated card
    Card::factory()->terminated()->count(1)->create(['user_id' => $user->id]);

    // User should have 3 active cards
    expect($user->active_cards)->toBe(3);
    expect($user->cards()->count())->toBe(6); // Total cards
    expect($user->activeCards()->count())->toBe(3); // Only active cards
});

test('user with no cards has zero active cards', function () {
    $user = User::factory()->create();

    expect($user->active_cards)->toBe(0);
});

test('user with only inactive cards has zero active cards', function () {
    $user = User::factory()->create();

    // Create only frozen and terminated cards
    Card::factory()->frozen()->count(2)->create(['user_id' => $user->id]);
    Card::factory()->terminated()->count(3)->create(['user_id' => $user->id]);

    expect($user->active_cards)->toBe(0);
    expect($user->cards()->count())->toBe(5); // Total cards
});

test('dashboard displays correct active cards count', function () {
    $user = User::factory()->create();

    // Create some active cards
    Card::factory()->active()->count(4)->create(['user_id' => $user->id]);
    Card::factory()->frozen()->count(1)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSeeText('4'); // Should see the count of 4 active cards
});
