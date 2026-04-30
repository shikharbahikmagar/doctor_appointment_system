<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. John Smith',
                'email' => 'doctor@gmail.com',
            ],
            [
                'name' => 'Dr. Sarah Khan',
                'email' => 'sarah@gmail.com',
            ],
            [
                'name' => 'Dr. Alex Rana',
                'email' => 'alex@gmail.com',
            ],
            [
                'name' => 'Dr. Priya Sharma',
                'email' => 'priya@gmail.com',
            ],
            [
                'name' => 'Dr. Amit Joshi',
                'email' => 'amit@gmail.com',
            ],
        ];

        foreach ($doctors as $doctor) {
            User::create([
                'name' => $doctor['name'],
                'email' => $doctor['email'],
                'role' => 'doctor',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
