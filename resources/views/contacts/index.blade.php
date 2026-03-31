@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="row">
    <div class="col-md-12 text-center text-md-start">
        <h2 class="page-heading display-6">
            <i class="bi bi-geo-alt text-primary"></i> Контакты и местоположение
        </h2>
        <p class="text-muted mb-4">Мы рядом с метро — приходите в удобное время.</p>
    </div>
</div>

<div class="row contacts-layout g-4">
    <div class="col-md-5 contacts-left-column d-flex flex-column">
        <div class="card mb-0">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-info-circle"></i> Контактная информация
                </h5>
                <hr>
                <div class="contact-info">
                    <p>
                        <strong><i class="bi bi-geo-alt"></i> Адрес:</strong><br>
                        г. Москва, ул. Тверская, д. 15, стр. 2<br>
                        (м. Тверская / м. Пушкинская)
                    </p>
                    
                    <p>
                        <strong><i class="bi bi-telephone"></i> Телефон:</strong><br>
                        +7 (495) 123-45-67<br>
                        +7 (916) 123-45-67
                    </p>
                    
                    <p>
                        <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                        <a href="mailto:info@beauty-salon.ru">info@beauty-salon.ru</a><br>
                        <a href="mailto:booking@beauty-salon.ru">booking@beauty-salon.ru</a>
                    </p>
                    
                    <p>
                        <strong><i class="bi bi-clock"></i> Режим работы:</strong><br>
                        Понедельник - Пятница: 9:00 - 21:00<br>
                        Суббота - Воскресенье: 10:00 - 19:00<br>
                        Без выходных
                    </p>
                </div>
            </div>
        </div>
        
        <div class="card mb-0">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-car-front"></i> Как добраться
                </h5>
                <hr>
                <p>
                    <strong> Метро:</strong><br>
                    ст. "Тверская" (выход к Тверской улице), далее пешком 3 минуты.<br>
                    ст. "Пушкинская" (выход к Тверскому бульвару), далее пешком 5 минут.
                </p>
                <p>
                    <strong> Общественный транспорт:</strong><br>
                    Автобусы: № 101, 904, остановка "Тверская улица"<br>
                    Маршрутные такси: № 12, 15м
                </p>
                <p>
                    <strong> Парковка:</strong><br>
                    Бесплатная парковка для клиентов за зданием салона.<br>
                    Парковка на 10 машиномест.
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-7 d-flex">
        <div class="card w-100 h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                    <i class="bi bi-map"></i> Мы на карте
                </h5>
                <hr>
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.contact-info p {
    margin-bottom: 15px;
}
.contact-info strong {
    color: var(--bs-primary);
    font-weight: 600;
}
#map {
    flex: 1;
    min-height: 720px;
    border-radius: 8px;
    box-shadow: 0 8px 28px rgba(46, 42, 45, 0.08);
}

.contacts-left-column {
    gap: 1.5rem;
}

@media (max-width: 767.98px) {
    #map {
        min-height: 420px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU"></script>
<script>
    ymaps.ready(init);
    
    function init() {
        // Координаты салона (Тверская улица, Москва)
        var salonCoordinates = [55.7646, 37.6062];
        
        var myMap = new ymaps.Map("map", {
            center: salonCoordinates,
            zoom: 16,
            controls: ['zoomControl', 'fullscreenControl', 'geolocationControl']
        });
        
        var myPlacemark = new ymaps.Placemark(salonCoordinates, {
            hintContent: 'Салон красоты "Бьюти"',
            balloonContent: `
                <div style="font-family: Arial, sans-serif;">
                    <strong>Салон красоты "Бьюти"</strong><br>
                     г. Москва, ул. Тверская, д. 15, стр. 2<br>
                     +7 (495) 123-45-67<br>
                     Пн-Пт: 9:00-21:00, Сб-Вс: 10:00-19:00<br>
                    <a href="https://maps.yandex.ru" target="_blank">Построить маршрут</a>
                </div>
            `
        }, {
            preset: 'islands#redDotIconWithCaption',
            balloonLayout: 'default#imageWithContent'
        });
        
        myMap.geoObjects.add(myPlacemark);
        
        // Добавляем масштабирование колесиком мыши
        myMap.behaviors.enable('scrollZoom');
        
        // Добавляем возможность перетаскивания
        myMap.behaviors.enable('drag');
    }
</script>
@endpush