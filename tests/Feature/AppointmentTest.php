<?php

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can create appointment', function () {

    $user = User::factory()->create(['role' => 'user']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/appointment', [
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'appointment_time' => '10:00',
            'remarks' => 'Test appointment',
        ]);

    $response->assertCreated();

    $this->assertDatabaseHas('appointments', [
        'doctor_id' => $doctor->id,
        'user_id' => $user->id,
    ]);
});



test('doctor can update appointment status', function () {

    $doctor = User::factory()->create(['role' => 'doctor']);
    $user = User::factory()->create(['role' => 'user']);

    $appointment = Appointment::create([
        'doctor_id' => $doctor->id,
        'user_id' => $user->id,
        'appointment_date' => '2027-01-01',
        'appointment_time' => '10:00',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($doctor, 'sanctum')
        ->patchJson("/api/appointment/{$appointment->id}", [
            'status' => 'confirmed',
        ]);

    $response->assertOk();

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => 'confirmed',
    ]);
});

test('slot cannot be double booked', function () {

    $user = User::factory()->create(['role' => 'user']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    $payload = [
        'doctor_id' => $doctor->id,
        'appointment_date' => '2027-01-01',
        'appointment_time' => '10:00',
        'remarks' => 'test',
    ];

    $response1 = $this->actingAs($user, 'sanctum')
        ->postJson('/api/appointment', $payload);

    $response1->assertCreated();

    $response2 = $this->actingAs($user, 'sanctum')
        ->postJson('/api/appointment', $payload);

    $response2->assertStatus(422);
});
