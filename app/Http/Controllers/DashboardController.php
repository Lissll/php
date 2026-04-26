<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\DashboardStats\AdminStats;
use App\Services\DashboardStats\ClientStats;
use App\Services\DashboardStats\ManagerStats;
use App\Services\DashboardStats\MasterStats;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AdminStats $adminStats,
        private readonly ManagerStats $managerStats,
        private readonly MasterStats $masterStats,
        private readonly ClientStats $clientStats
    ) {
    }

    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            $services = Service::all();
            return view('dashboard.guest', compact('services'));
        }

        $stats = match (true) {
            $user->isAdmin() => $this->adminStats->get(),
            $user->isManager() => $this->managerStats->get(),
            $user->isMaster() => $this->masterStats->get($user),
            default => $this->clientStats->get($user),
        };
        
        return view('dashboard.index', compact('user', 'stats'));
    }
}