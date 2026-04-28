@extends('layouts.app')

@section('title', 'Услуги')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="page-heading mb-0">
        <i class="bi bi-stars text-primary"></i> Наши услуги
    </h2>
    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
        <a href="{{ route('services.manage') }}" class="btn btn-primary">
            <i class="bi bi-gear"></i> Управление услугами
        </a>
    @endif
</div>

<div class="row">
    @forelse($services as $service)
        <div class="col-md-4 mb-4">
            <div class="card h-100 service-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-star-fill text-warning"></i> 
                        {{ $service->name }}
                    </h5>
                    <p class="card-text">{{ $service->description }}</p>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Длительность:</small>
                            <div class="fw-bold">{{ $service->duration }} минут</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Стоимость:</small>
                            <div class="fw-bold text-primary">{{ number_format($service->price, 2) }} ₽</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    @if(Auth::user()->isClient())
                        <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-calendar-plus"></i> Записаться
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Услуги пока не добавлены
            </div>
        </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
.service-card {
    transition: transform 0.3s;
}
.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endpush