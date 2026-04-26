<?php

namespace App\Services\DashboardStats;

use App\Models\Appointment;
use App\Models\User;

class ManagerStats
{
    public function get(): array
    {
        $appointmentStats = Appointment::selectRaw("
            COUNT(*) as total_appointments,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_appointments,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_appointments
        ")->first();

        return [
            'total_appointments' => (int) ($appointmentStats->total_appointments ?? 0),
            'pending_appointments' => (int) ($appointmentStats->pending_appointments ?? 0),
            'completed_appointments' => (int) ($appointmentStats->completed_appointments ?? 0),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'total_clients' => User::where('role', User::ROLE_CLIENT)->count(),
        ];
    }
}
