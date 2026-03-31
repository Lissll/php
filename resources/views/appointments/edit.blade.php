@extends('layouts.app')

@section('title', 'Редактирование записи')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="bi bi-pencil"></i> Редактирование записи #{{ $appointment->id }}
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Клиент</label>
                        <input type="text" class="form-control" value="{{ $appointment->client->name }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label for="service_id" class="form-label">Услуга</label>
                        <select class="form-select @error('service_id') is-invalid @enderror" 
                                id="service_id" name="service_id" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        {{ $appointment->service_id == $service->id ? 'selected' : '' }}
                                        data-duration="{{ $service->duration }}"
                                        data-price="{{ $service->price }}">
                                    {{ $service->name }} - {{ $service->duration }} мин. - {{ number_format($service->price, 2) }} ₽
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="master_id" class="form-label">Мастер</label>
                        <select class="form-select @error('master_id') is-invalid @enderror" 
                                id="master_id" name="master_id" required>
                            @foreach($masters as $master)
                                <option value="{{ $master->id }}" 
                                    {{ $appointment->master_id == $master->id ? 'selected' : '' }}>
                                    {{ $master->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('master_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Дата и время</label>
                        <input type="datetime-local" 
                               class="form-control @error('appointment_date') is-invalid @enderror" 
                               id="appointment_date" 
                               name="appointment_date" 
                               value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                               required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Статус</label>
                        <div>
                            <span class="status-badge status-{{ $appointment->status }}">
                                @switch($appointment->status)
                                    @case('pending')  Ожидает @break
                                    @case('confirmed')  Подтверждена @break
                                    @case('completed')  Выполнена @break
                                    @case('cancelled')  Отменена @break
                                @endswitch
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection