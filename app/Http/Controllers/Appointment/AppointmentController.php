<?php

namespace App\Http\Controllers\Appointment;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CreateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\Appointment\AppointmentService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppointmentController extends Controller
{

    /**
     * Make Appointment
     */
    public function store(CreateAppointmentRequest $request, AppointmentService $appointmentService): JsonResponse
    {
        $req = $request->validated();

        $resp = $appointmentService->store($req);

        return ApiResponse::success($resp, 'Appointment Booked Successfully.', 201);
    }

    /**
     * Get patient Appointments
     */

    public function myAppointments(): JsonResponse
    {
        $resp = Appointment::with('patient', 'doctor')->where('user_id', Auth::user()->id)->get();

        return ApiResponse::success(AppointmentResource::collection($resp), 'Appointments Fetched Successfully.', 200);
    }

    /**
     * Get Doctor Schedules
     */
    public function mySchedules(): JsonResponse
    {
        $resp = Appointment::with('patient', 'doctor')->where('doctor_id', Auth::user()->id)->get();

        return ApiResponse::success(AppointmentResource::collection($resp), 'Schedules Fetched Successfully.', 200);
    }
}
