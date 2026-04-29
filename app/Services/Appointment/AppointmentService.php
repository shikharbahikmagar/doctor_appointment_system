<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    /*
     * @param $req
     */
    public function store(array $req)
    {

        try {

            $appointmentExists = Appointment::where('doctor_id', $req['doctor_id'])
                ->where('appointment_date', $req['appointment_date'])
                ->where('appointment_time', $req['appointment_time'])
                ->exists();

            if ($appointmentExists) {
                throw ValidationException::withMessages([
                    'appointment_time' => 'Time Slot Already Booked.'
                ]);
            }

            return Appointment::create([
                'user_id' => Auth::user()->id,
                'doctor_id' => $req['doctor_id'],
                'appointment_date' => $req['appointment_date'],
                'appointment_time' => $req['appointment_time'],
                'remarks' => $req['remarks'],
            ]);
        } catch (Exception $e) {
            Log::error('Error Booking Appointment', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }
}
