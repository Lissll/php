<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            $services = Service::all();
            return view('dashboard.guest', compact('services'));
        }
        
        $stats = [];
        
        if ($user->isAdmin()) {
            $stats['total_appointments'] = Appointment::count();
            $stats['pending_appointments'] = Appointment::where('status', 'pending')->count();
            $stats['completed_appointments'] = Appointment::where('status', 'completed')->count();
            $stats['today_appointments'] = Appointment::whereDate('appointment_date', today())->count();
            $stats['total_users'] = \App\Models\User::count();
            $stats['total_masters'] = \App\Models\User::where('role', 'master')->count();
        } elseif ($user->isManager()) {
            $stats['total_appointments'] = Appointment::count();
            $stats['pending_appointments'] = Appointment::where('status', 'pending')->count();
            $stats['completed_appointments'] = Appointment::where('status', 'completed')->count();
            $stats['today_appointments'] = Appointment::whereDate('appointment_date', today())->count();
            $stats['total_clients'] = \App\Models\User::where('role', 'client')->count();
        } elseif ($user->isMaster()) {
            $stats['my_today_appointments'] = Appointment::where('master_id', $user->id)
                ->whereDate('appointment_date', today())
                ->count();
            $stats['my_pending_appointments'] = Appointment::where('master_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $stats['my_week_appointments'] = Appointment::where('master_id', $user->id)
                ->whereBetween('appointment_date', [now(), now()->addDays(7)])
                ->count();
        } else {
            $stats['my_appointments'] = Appointment::where('client_id', $user->id)->count();
            $stats['my_upcoming_appointments'] = Appointment::where('client_id', $user->id)
                ->where('appointment_date', '>', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count();
            $stats['my_completed_appointments'] = Appointment::where('client_id', $user->id)
                ->where('status', 'completed')
                ->count();
        }
        
        return view('dashboard.index', compact('user', 'stats'));
    }
}