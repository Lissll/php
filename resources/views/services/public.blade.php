@extends('layouts.app')

@section('title', 'Управление услугами')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Добавить услугу</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('services.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Название услуги</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Длительность (мин)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Стоимость (руб.)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        Добавить услугу
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Список услуг</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Длительность</th>
                                <th>Стоимость</th>
                                <th>Действия</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>
                                        <strong>{{ $service->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                    </td>
                                    <td>{{ $service->duration }} мин.</td>
                                    <td>{{ number_format($service->price, 2) }} руб.</td>
                                    <td>
                                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                            Редактировать
                                        </a>
                                        <form id="delete-service-form-{{ $service->id }}" action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger open-delete-service-modal"
                                                    data-service-name="{{ $service->name }}"
                                                    data-form-id="delete-service-form-{{ $service->id }}">
                                                Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteServiceConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление услуги</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить услугу <strong id="delete-service-public-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-service-public-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('deleteServiceConfirmModal');
    if (!modalElement) return;

    const deleteModal = new bootstrap.Modal(modalElement);
    const serviceNameElement = document.getElementById('delete-service-public-name');
    const confirmBtn = document.getElementById('confirm-delete-service-public-btn');
    let targetFormId = null;

    document.querySelectorAll('.open-delete-service-modal').forEach(button => {
        button.addEventListener('click', function () {
            targetFormId = this.dataset.formId;
            serviceNameElement.textContent = this.dataset.serviceName || 'без названия';
            deleteModal.show();
        });
    });

    confirmBtn.addEventListener('click', function () {
        if (!targetFormId) return;
        const form = document.getElementById(targetFormId);
        if (form) form.submit();
    });
});
</script>
@endpush
@extends('layouts.app')

@section('title', 'Управление услугами')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Добавить услугу</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('services.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Название услуги</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Длительность (мин)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Стоимость (руб.)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        Добавить услугу
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Список услуг</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Длительность</th>
                                <th>Стоимость</th>
                                <th>Действия</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>
                                        <strong>{{ $service->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                    </td>
                                    <td>{{ $service->duration }} мин.</td>
                                    <td>{{ number_format($service->price, 2) }} руб.</td>
                                    <td>
                                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                            Редактировать
                                        </a>
                                        <form id="delete-service-form-{{ $service->id }}" action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger open-delete-service-modal"
                                                    data-service-name="{{ $service->name }}"
                                                    data-form-id="delete-service-form-{{ $service->id }}">
                                                Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteServiceConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление услуги</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить услугу <strong id="delete-service-public-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-service-public-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('deleteServiceConfirmModal');
    if (!modalElement) return;

    const deleteModal = new bootstrap.Modal(modalElement);
    const serviceNameElement = document.getElementById('delete-service-public-name');
    const confirmBtn = document.getElementById('confirm-delete-service-public-btn');
    let targetFormId = null;

    document.querySelectorAll('.open-delete-service-modal').forEach(button => {
        button.addEventListener('click', function () {
            targetFormId = this.dataset.formId;
            serviceNameElement.textContent = this.dataset.serviceName || 'без названия';
            deleteModal.show();
        });
    });

    confirmBtn.addEventListener('click', function () {
        if (!targetFormId) return;
        const form = document.getElementById(targetFormId);
        if (form) form.submit();
    });
});
</script>
@endpush