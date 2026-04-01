@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="page-heading mb-0">
        @if(Auth::user()->isManager())
            Клиенты
        @else
            Команда и пользователи
        @endif
    </h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        Создать пользователя
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge bg-danger">Администратор</span>
                                @elseif($user->isManager())
                                    <span class="badge bg-warning">Менеджер</span>
                                @elseif($user->isMaster())
                                    <span class="badge bg-info">Мастер</span>
                                @else
                                    <span class="badge bg-secondary">Клиент</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                @php
                                    $canManage = Auth::user()->isAdmin()
                                        || (Auth::user()->isManager() && $user->isClient());
                                @endphp
                                @if($canManage)
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        Редактировать
                                    </a>
                                @endif
                                @if($canManage && $user->id !== Auth::id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить пользователя?')">
                                            Удалить
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection