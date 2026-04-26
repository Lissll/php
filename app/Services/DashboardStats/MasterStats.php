<?php

namespace App\Services\DashboardStats;

use App\Models\Appointment;
use App\Models\User;

class MasterStats
{
    public function get(User $user): array
    {
        $baseQuery = Appointment::where('master_id', $user->id);

        $statusStats = (clone $baseQuery)->selectRaw("
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as my_pending_appointments
        ")->first();

        return [
            'my_today_appointments' => (clone $baseQuery)->whereDate('appointment_date', today())->count(),
            'my_pending_appointments' => (int) ($statusStats->my_pending_appointments ?? 0),
            'my_week_appointments' => (clone $baseQuery)
                ->whereBetween('appointment_date', [now(), now()->addDays(7)])
                ->count(),
        ];
    }
}
