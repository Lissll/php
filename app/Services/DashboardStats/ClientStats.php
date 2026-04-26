<?php

namespace App\Services\DashboardStats;

use App\Models\Appointment;
use App\Models\User;

class ClientStats
{
    public function get(User $user): array
    {
        $baseQuery = Appointment::where('client_id', $user->id);

        $statusStats = (clone $baseQuery)->selectRaw("
            COUNT(*) as my_appointments,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as my_completed_appointments
        ")->first();

        return [
            'my_appointments' => (int) ($statusStats->my_appointments ?? 0),
            'my_upcoming_appointments' => (clone $baseQuery)
                ->where('appointment_date', '>', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'my_completed_appointments' => (int) ($statusStats->my_completed_appointments ?? 0),
        ];
    }
}
