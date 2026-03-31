<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Belle Époque — салон красоты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @include('partials.salon-theme')
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-salon sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-flower1"></i> Belle Époque
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Услуги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contacts.index') }}">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <h5 class="card-title mb-0" style="font-family: var(--salon-font); font-size: 1.1rem; font-weight: 600;">{{ $service->name }}</h5>
                                <i class="bi bi-stars text-primary fs-5 opacity-75"></i>
                            </div>
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

    <footer class="footer-salon">
        <div class="container">
            <div class="mb-2" style="font-family: var(--salon-font); font-size: 1.05rem; font-weight: 700; color: rgba(255,255,255,0.92); letter-spacing: -0.02em;">Belle Époque</div>
            <span class="text-muted">© {{ date('Y') }} Салон красоты. Все права защищены.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
