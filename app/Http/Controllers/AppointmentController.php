<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isManager()) {
            $appointments = Appointment::with(['client', 'service', 'master'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        } elseif ($user->isMaster()) {
            $appointments = Appointment::with(['client', 'service'])
                ->where('master_id', $user->id)
                ->orderBy('appointment_date', 'asc')
                ->get();
        } else {
            $appointments = Appointment::with(['service', 'master'])
                ->where('client_id', $user->id)
                ->orderBy('appointment_date', 'desc')
                ->get();
        }
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        $masters = User::where('role', User::ROLE_MASTER)->get();
        $clients = User::where('role', User::ROLE_CLIENT)->get();
        $selectedMaster = null;
        $availableSlots = [];
        $selectedServiceId = request()->integer('service_id');
        if (! $services->contains('id', $selectedServiceId)) {
            $selectedServiceId = null;
        }
        
        $user = Auth::user();
        $isAdminOrManager = $user->isAdmin() || $user->isManager();
        
        return view('appointments.create', compact('services', 'masters', 'clients', 'selectedMaster', 'availableSlots', 'isAdminOrManager', 'selectedServiceId'));
    }

    public function getAvailableSlots(Request $request)
    {
        $masterId = $request->master_id;
        $date = $request->date;
        $serviceId = $request->service_id;
        
        if (!$masterId || !$date || !$serviceId) {
            return response()->json([]);
        }
        
        $master = User::find($masterId);
        $service = Service::find($serviceId);
        
        if (!$master || !$service) {
            return response()->json([]);
        }
        
        $selectedDate = Carbon::parse($date);
        $dayOfWeek = $selectedDate->dayOfWeek;
        
        $workStart = 9;
        $workEnd = 21;
        
        if ($dayOfWeek == 6 || $dayOfWeek == 0) {
            $workStart = 10;
            $workEnd = 19;
        }
        
        $existingAppointments = Appointment::where('master_id', $masterId)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->get();
        
        $availableSlots = [];
        $currentTime = Carbon::parse($date . ' ' . $workStart . ':00');
        $endTime = Carbon::parse($date . ' ' . $workEnd . ':00');
        $duration = $service->duration;
        
        while ($currentTime->copy()->addMinutes($duration) <= $endTime) {
            $slotEnd = $currentTime->copy()->addMinutes($duration);
            $isAvailable = true;
            
            foreach ($existingAppointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->appointment_date);
                $appointmentEnd = $appointmentStart->copy()->addMinutes(
                    $appointment->service->duration
                );
                
                if ($currentTime < $appointmentEnd && $slotEnd > $appointmentStart) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable && $currentTime > Carbon::now()) {
                $availableSlots[] = $currentTime->format('H:i');
            }
            
            $currentTime->addMinutes(30);
        }
        
        return response()->json($availableSlots);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);
        
        if ($user->isAdmin() || $user->isManager()) {
            $request->validate([
                'client_id' => 'required|exists:users,id',
            ]);
            $clientId = $request->client_id;
        } else {
            $clientId = $user->id;
        }
        
        $appointmentDateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        
        if ($appointmentDateTime < Carbon::now()) {
            return back()->withErrors(['appointment_date' => 'Нельзя записаться на прошедшее время'])->withInput();
        }
        
        $existingAppointment = Appointment::where('master_id', $validated['master_id'])
            ->where('appointment_date', $appointmentDateTime)
            ->whereNotIn('status', ['cancelled'])
            ->first();
            
        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'Это время уже занято'])->withInput();
        }

        Appointment::create([
            'client_id' => $clientId,
            'service_id' => $validated['service_id'],
            'master_id' => $validated['master_id'],
            'appointment_date' => $appointmentDateTime,
            'status' => Appointment::STATUS_PENDING,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Запись успешно создана');
    }

    public function edit(Appointment $appointment)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isManager() && $user->id !== $appointment->client_id) {
            abort(403);
        }
        
        $services = Service::all();
        $masters = User::where('role', User::ROLE_MASTER)->get();
        
        return view('appointments.edit', compact('appointment', 'services', 'masters'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Запись успешно обновлена');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        try {
            $status = $request->input('status');
            
            if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
                return response()->json(['success' => false, 'error' => 'Некорректный статус'], 400);
            }

            $appointment->status = $status;
            $appointment->save();

            $statusText = $this->getStatusText($status);
            $statusClass = $this->getStatusClass($status);

            return response()->json([
                'success' => true,
                'status' => $status,
                'status_text' => $statusText,
                'status_class' => $statusClass,
                'message' => 'Статус обновлен'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, Appointment $appointment)
    {
        try {
            $appointment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Запись удалена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    private function getStatusText($status)
    {
        switch ($status) {
            case 'pending': return 'Ожидает';
            case 'confirmed': return 'Подтверждена';
            case 'completed': return 'Выполнена';
            case 'cancelled': return 'Отменена';
            default: return $status;
        }
    }
    
    private function getStatusClass($status)
    {
        switch ($status) {
            case 'pending': return 'status-pending';
            case 'confirmed': return 'status-confirmed';
            case 'completed': return 'status-completed';
            case 'cancelled': return 'status-cancelled';
            default: return '';
        }
    }
}