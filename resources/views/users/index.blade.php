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
                                    <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger open-delete-user-modal"
                                                data-user-name="{{ $user->name }}"
                                                data-form-id="delete-user-form-{{ $user->id }}">
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

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить пользователя <strong id="delete-user-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-user-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('deleteUserModal');
    if (!modalElement) return;

    const deleteUserModal = new bootstrap.Modal(modalElement);
    const deleteUserName = document.getElementById('delete-user-name');
    const confirmDeleteBtn = document.getElementById('confirm-delete-user-btn');
    let targetFormId = null;

    document.querySelectorAll('.open-delete-user-modal').forEach(button => {
        button.addEventListener('click', function () {
            targetFormId = this.dataset.formId;
            deleteUserName.textContent = this.dataset.userName || 'этого пользователя';
            deleteUserModal.show();
        });
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (!targetFormId) return;
        const targetForm = document.getElementById(targetFormId);
        if (targetForm) targetForm.submit();
    });
});
</script>
@endpush