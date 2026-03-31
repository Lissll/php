@extends('layouts.app')

@section('title', 'Редактирование пользователя')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Редактирование пользователя: {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Роль</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            @if(Auth::user()->isAdmin())
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Администратор</option>
                                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Менеджер</option>
                                <option value="master" {{ $user->role === 'master' ? 'selected' : '' }}>Мастер</option>
                                <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Клиент</option>
                            @elseif(Auth::user()->isManager())
                                <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Клиент</option>
                            @endif
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            Сохранить изменения
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            Назад
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection