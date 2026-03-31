@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="row justify-content-center py-lg-3">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card shadow">
            <div class="card-header">
                <h4 class="mb-0">Добро пожаловать</h4>
                <small class="opacity-75">Вход в личный кабинет</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Запомнить меня</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Войти</button>
                </form>

                <div class="alert alert-light border-0 mt-4 mb-0 small" style="background: rgba(157, 107, 115, 0.08); color: #4a3d40;">
                    <strong>Тестовые аккаунты:</strong><br>
                    <span class="text-muted">admin@gmail.com</span> · <span class="text-muted">manager@gmail.com</span> · <span class="text-muted">master@gmail.com</span> · <span class="text-muted">user@gmail.com</span><br>
                    Пароль для всех: <code class="text-dark">123456</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
