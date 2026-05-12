<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function publicIndex()
    {
        $services = Service::all();
        return view('services.public', compact('services'));
    }

    // Страница услуг для авторизованных пользователей
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }
    public function manage()
    {
        $services = Service::all();
        return view('services.manage', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create($validated);

        return redirect()->route('services.manage')
            ->with('success', 'Услуга успешно добавлена');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
        ]);

        $service->update($validated);

        return redirect()->route('services.manage')
            ->with('success', 'Услуга успешно обновлена');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        
        return redirect()->route('services.manage')
            ->with('success', 'Услуга удалена');
    }
}