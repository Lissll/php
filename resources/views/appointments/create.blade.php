@extends('layouts.app')

@section('title', 'Новая запись')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Новая запись</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.store') }}" id="appointment-form">
                    @csrf
                    
                    @if($isAdminOrManager)
                    <div class="mb-3">
                        <label for="client_id" class="form-label">Клиент</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" 
                                id="client_id" name="client_id" required>
                            <option value="">-- Выберите клиента --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="service_id" class="form-label">Выберите услугу</label>
                        <select class="form-select @error('service_id') is-invalid @enderror" 
                                id="service_id" name="service_id" required>
                            <option value="">-- Выберите услугу --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        data-duration="{{ $service->duration }}"
                                        data-price="{{ $service->price }}"
                                        {{ (string) old('service_id', $selectedServiceId ?? '') === (string) $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} - {{ $service->duration }} мин. - {{ number_format($service->price, 2) }} руб.
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="master_id" class="form-label">Выберите мастера</label>
                        <select class="form-select @error('master_id') is-invalid @enderror" 
                                id="master_id" name="master_id" required disabled>
                            <option value="">-- Сначала выберите услугу --</option>
                        </select>
                        @error('master_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Дата</label>
                        <input type="date" 
                               class="form-control @error('appointment_date') is-invalid @enderror" 
                               id="appointment_date" 
                               name="appointment_date" 
                               min="{{ now()->format('Y-m-d') }}"
                               required disabled>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Время</label>
                        <select class="form-select @error('appointment_time') is-invalid @enderror" 
                                id="appointment_time" name="appointment_time" required disabled>
                            <option value="">-- Сначала выберите дату и мастера --</option>
                        </select>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info" id="service-info">
                        Выберите услугу для отображения информации
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                            Записаться
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_id');
    const masterSelect = document.getElementById('master_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const serviceInfo = document.getElementById('service-info');
    const submitBtn = document.getElementById('submit-btn');
    
    let masters = @json($masters);
    
    function checkFormComplete() {
        if (serviceSelect.value && masterSelect.value && dateInput.value && timeSelect.value) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
    
    serviceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const duration = selectedOption.dataset.duration;
            const price = selectedOption.dataset.price;
            const name = selectedOption.text.split(' - ')[0];
            serviceInfo.innerHTML = `
                <strong>${name}</strong><br>
                Длительность: ${duration} минут<br>
                Стоимость: ${Number(price).toFixed(2)} руб.
            `;
            
            masterSelect.innerHTML = '<option value="">-- Выберите мастера --</option>';
            masters.forEach(master => {
                masterSelect.innerHTML += `<option value="${master.id}">${master.name}</option>`;
            });
            masterSelect.disabled = false;
            dateInput.disabled = false;
        } else {
            serviceInfo.innerHTML = 'Выберите услугу для отображения информации';
            masterSelect.innerHTML = '<option value="">-- Сначала выберите услугу --</option>';
            masterSelect.disabled = true;
            dateInput.disabled = true;
            timeSelect.innerHTML = '<option value="">-- Сначала выберите дату и мастера --</option>';
            timeSelect.disabled = true;
            submitBtn.disabled = true;
        }
        checkFormComplete();
    });

    if (serviceSelect.value) {
        serviceSelect.dispatchEvent(new Event('change'));
    }
    
    function loadAvailableSlots() {
        const masterId = masterSelect.value;
        const date = dateInput.value;
        const serviceId = serviceSelect.value;
        
        if (masterId && date && serviceId) {
            fetch('{{ route("appointments.available-slots") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    master_id: masterId,
                    date: date,
                    service_id: serviceId
                })
            })
            .then(response => response.json())
            .then(slots => {
                timeSelect.innerHTML = '<option value="">-- Выберите время --</option>';
                if (slots.length > 0) {
                    slots.forEach(slot => {
                        timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                    });
                    timeSelect.disabled = false;
                } else {
                    timeSelect.innerHTML = '<option value="">-- Нет свободного времени --</option>';
                    timeSelect.disabled = true;
                }
                checkFormComplete();
            })
            .catch(error => {
                console.error('Error:', error);
                timeSelect.innerHTML = '<option value="">-- Ошибка загрузки --</option>';
                timeSelect.disabled = true;
            });
        } else {
            timeSelect.innerHTML = '<option value="">-- Сначала выберите дату и мастера --</option>';
            timeSelect.disabled = true;
            checkFormComplete();
        }
    }
    
    masterSelect.addEventListener('change', function() {
        loadAvailableSlots();
    });
    
    dateInput.addEventListener('change', function() {
        loadAvailableSlots();
    });
    
    timeSelect.addEventListener('change', function() {
        checkFormComplete();
    });
    
    const form = document.getElementById('appointment-form');
    form.addEventListener('submit', function(e) {
        const selectedDate = new Date(dateInput.value);
        const now = new Date();
        now.setHours(0, 0, 0, 0);
        
        if (selectedDate < now) {
            e.preventDefault();
            alert('Нельзя записаться на прошедшую дату');
            return false;
        }
        
        return true;
    });
});
</script>
@endpush