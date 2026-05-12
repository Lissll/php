@extends('layouts.guest')
@section('title', 'Belle Époque — салон красоты')
@section('content')
    <section class="hero-salon">
        <div class="container text-center">
            <p class="text-uppercase small mb-2" style="letter-spacing: 0.25em; opacity: 0.75;">уход · стиль · гармония</p>
            <h1 class="mb-3">Ваша красота — наша страсть</h1>
            <p class="lead mx-auto" style="max-width: 32rem;">Индивидуальный подход, бережные процедуры и атмосфера, в которой хочется возвращаться снова и снова.</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-3">Записаться онлайн</a>
        </div>
    </section>

    <div class="container flex-grow-1 pb-5">
        <div class="row mb-2">
            <div class="col-12 text-center">
                <h2 class="page-heading display-6">Наши услуги</h2>
                <p class="text-muted mx-auto mb-0" style="max-width: 28rem;">Выберите процедуру и забронируйте удобное время после входа в личный кабинет.</p>
            </div>
        </div>

        <div class="row g-4 mt-1">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2" style="font-family: var(--salon-font); font-size: 1.1rem; font-weight: 600;">{{ $service->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $service->description }}</p>
                            <hr class="my-3 opacity-25">
                            <div class="row g-2 small">
                                <div class="col-6">
                                    <span class="text-muted d-block">Длительность</span>
                                    <span class="fw-semibold">{{ $service->duration }} мин</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-muted d-block">Стоимость</span>
                                    <span class="fw-semibold text-primary">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pt-0 border-0 pb-4 px-4">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                                Войти, чтобы записаться
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center shadow-sm">
                        Услуги скоро появятся — следите за обновлениями.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
