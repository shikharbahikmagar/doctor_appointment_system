<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\UserRole;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{

    /**
     * Fetch all Doctors
     */
    public function index(): JsonResponse
    {
        $doctors = User::where('role', UserRole::DOCTOR)->get();

        return ApiResponse::success($doctors, 'Doctors Fetched Successfully.', 200);
    }
}
