<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can register successfully', function () {

    $payload = [
        'name' => 'Shikhar Magar',
        'email' => 'shikhar@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'user',
    ];

    $response = $this->postJson('/api/auth/register', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'email' => 'shikhar@example.com',
    ]);
});

test('user can login successfully', function () {

    $user = User::factory()->create([
        'password' => 'password', // auto hashed via cast
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'user',
            'token',
        ]
    ]);
});


test('authenticated user can fetch all doctors', function () {

    $user = User::factory()->create();

    // create doctors
    User::factory()->count(3)->create([
        'role' => 'doctor',
    ]);

    // create normal users (should NOT appear)
    User::factory()->count(2)->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->getJson('/api/doctors');

    $response->assertOk();
});
