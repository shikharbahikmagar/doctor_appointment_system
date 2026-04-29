<?php

namespace App\Enums\Appointment;

enum AppointmentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
}
