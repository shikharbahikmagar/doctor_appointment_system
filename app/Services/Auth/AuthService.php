<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{


    /*
     * @param $data
     *
    */
    public function store(array $data): User
    {
        try {

            $newUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),

            ]);

            return $newUser;
        } catch (Exception $e) {

            Log::error('Error while registering user', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' =>  $e->getLine(),
            ]);

            throw $e;
        }
    }


    /*
     * @param $data
     *
    */
    public function login(array $data)
    {
        try {


            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials.'],

                ]);
            }

            $user = Auth::user();
            $token = $user->createToken('dastoken')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (Exception $e) {

            Log::error('Error user login', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' =>  $e->getLine(),
            ]);


            throw $e;
        }
    }
}
