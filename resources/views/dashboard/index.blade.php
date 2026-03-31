@extends('layouts.app')

@section('title', 'Дашборд')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card dash-welcome-card mb-4">
            <div class="card-body">
                <h4 class="mb-0">Добро пожаловать, {{ $user->name }}!</h4>
                <p class="mb-0">
                    Роль: 
                    @if($user->isAdmin()) Администратор
                    @elseif($user->isManager()) Менеджер
                    @elseif($user->isMaster()) Мастер
                    @else Клиент
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if($user->isAdmin())
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-info">
                <div class="card-body">
                    <h5 class="card-title">Всего записей</h5>
                    <p class="card-text display-4">{{ $stats['total_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ожидают подтверждения</h5>
                    <p class="card-text display-4">{{ $stats['pending_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-success">
                <div class="card-body">
                    <h5 class="card-title">Выполнено</h5>
                    <p class="card-text display-4">{{ $stats['completed_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Записи на сегодня</h5>
                    <p class="card-text display-4">{{ $stats['today_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card text-white stat-card-soft bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Всего пользователей</h5>
                    <p class="card-text display-4">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card text-white stat-card-soft bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Мастеров</h5>
                    <p class="card-text display-4">{{ $stats['total_masters'] }}</p>
                </div>
            </div>
        </div>
        
    @elseif($user->isManager())
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-info">
                <div class="card-body">
                    <h5 class="card-title">Всего записей</h5>
                    <p class="card-text display-4">{{ $stats['total_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ожидают подтверждения</h5>
                    <p class="card-text display-4">{{ $stats['pending_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-success">
                <div class="card-body">
                    <h5 class="card-title">Выполнено</h5>
                    <p class="card-text display-4">{{ $stats['completed_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-white stat-card-soft bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Записи на сегодня</h5>
                    <p class="card-text display-4">{{ $stats['today_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 mb-4">
            <div class="card text-white stat-card-soft bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Всего клиентов</h5>
                    <p class="card-text display-4">{{ $stats['total_clients'] }}</p>
                </div>
            </div>
        </div>
        
    @elseif($user->isMaster())
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-success">
                <div class="card-body">
                    <h5 class="card-title">Записи на сегодня</h5>
                    <p class="card-text display-4">{{ $stats['my_today_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ожидают подтверждения</h5>
                    <p class="card-text display-4">{{ $stats['my_pending_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-info">
                <div class="card-body">
                    <h5 class="card-title">Записи на неделю</h5>
                    <p class="card-text display-4">{{ $stats['my_week_appointments'] }}</p>
                </div>
            </div>
        </div>
        
    @else
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-info">
                <div class="card-body">
                    <h5 class="card-title">Мои записи</h5>
                    <p class="card-text display-4">{{ $stats['my_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Предстоящие записи</h5>
                    <p class="card-text display-4">{{ $stats['my_upcoming_appointments'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white stat-card-soft bg-success">
                <div class="card-body">
                    <h5 class="card-title">Выполнено</h5>
                    <p class="card-text display-4">{{ $stats['my_completed_appointments'] }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Быстрые действия</h5>
            </div>
            <div class="card-body">
                <div class="row quick-actions">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary w-100">
                            Мои записи
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('services.index') }}" class="btn btn-outline-primary w-100">
                            Услуги
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary w-100">
                            Новая запись
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-primary w-100">
                            Личный кабинет
                        </a>
                    </div>
                    @if($user->isAdmin() || $user->isManager())
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100">
                            Управление пользователями
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection