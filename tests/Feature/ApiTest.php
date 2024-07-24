<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can register a user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type']);
});

it('can login a user', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type']);
});

it('can logout a user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)->assertJson(['message' => 'Logged out successfully']);
});

it('can fetch chirps', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->getJson('/api/chirps');

    $response->assertStatus(200);
});

it('can post a chirp', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/chirps', [
        'message' => 'This is a new chirp!'
    ]);

    $response->assertStatus(201);
});

it('can delete a chirp', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $chirp = $user->chirps()->create(['message' => 'This is a chirp to delete']);

    $response = $this->deleteJson("/api/chirps/{$chirp->id}");

    $response->assertStatus(200)->assertJson(['message' => 'You have successfully delete the record.']);
});
