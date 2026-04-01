# Паспорт проекта (структура + ответственность файлов)

Этот файл — “карта” проекта `c:\php-main`: **что за что отвечает**, какие файлы **системные (Laravel)**, а какие **созданы/изменены вами под CRM салона**.

## Легенда

- **[SYSTEM]**: стандартный Laravel/инфраструктура/зависимости. Обычно не меняют или меняют редко.
- **[CUSTOM]**: прикладной код CRM салона (логика, страницы, доменные сущности).
- **[MIXED]**: системный файл, но в нём есть ваши настройки/подключения.

## Точки входа (самое важное)

- **HTTP-вход**: `public/index.php` **[SYSTEM]** — старт обработки веб-запроса.
- **Сборка приложения**: `bootstrap/app.php` **[MIXED]** — подключает роуты и регистрирует alias middleware `role`.
- **Маршруты**: `routes/web.php` **[CUSTOM]** — вся “карта страниц” приложения (какие URL ведут в какие контроллеры).
- **Layout и тема**: `resources/views/layouts/app.blade.php` + `resources/views/partials/salon-theme.blade.php` **[CUSTOM]** — базовая верстка и дизайн сайта.

## Структура проекта (высокий уровень)

> `vendor/` и `node_modules/` не расписываю пофайлово (там тысячи зависимостей). Их смысл описан отдельно.

```
app/                          [CUSTOM] прикладной код
bootstrap/                     [SYSTEM/MIXED] ранняя инициализация + кэши
config/                        [SYSTEM/MIXED] конфигурация Laravel (через .env)
database/                      [CUSTOM+SYSTEM] миграции/сидеры/фабрики
public/                        [SYSTEM] веб-корень
resources/                     [CUSTOM] шаблоны (Blade) + исходники фронта
routes/                        [CUSTOM+SYSTEM] web/console маршруты
storage/                       [SYSTEM] runtime-данные (логи, кеш, сессии, compiled views)
tests/                         [SYSTEM] тесты (сейчас примерные)
vendor/                        [SYSTEM] PHP зависимости Composer
node_modules/                  [SYSTEM] npm зависимости (Vite/Bootstrap/etc.)

artisan                        [SYSTEM] CLI вход (php artisan ...)
composer.json / composer.lock  [SYSTEM] PHP зависимости и версии
package.json / package-lock    [SYSTEM] frontend зависимости и версии
vite.config.js                 [MIXED] конфиг сборки фронта (Vite)
.env / .env.example            [SYSTEM/MIXED] настройки окружения
phpunit.xml                    [SYSTEM] конфиг тестов
```

---

## `app/` — прикладной код (CRM салона)

### `app/Http/Controllers` **[CUSTOM]**

Контроллеры принимают запросы по маршрутам и возвращают страницы/ответы.

- `AppointmentController.php`
  - **роль**: управление записями (листинг, создание, редактирование, удаление).
  - **функции (по смыслу)**: загрузка записей для разных ролей, выбор слотов времени, обновление статуса записи.
  - **связано с**: `Appointment`, `Service`, `User` и views `resources/views/appointments/*`.

- `ServiceController.php`
  - **роль**: публичный список услуг + управление услугами (для admin/manager).
  - **связано с**: модель `Service` и views `resources/views/services/*`.

- `UserController.php`
  - **роль**: управление пользователями (resource-маршруты).
  - **связано с**: модель `User` и views `resources/views/users/*`.

- `DashboardController.php`
  - **роль**: главная/дашборд, статистика и “быстрые действия” в зависимости от роли.
  - **views**: `resources/views/dashboard/index.blade.php`, `dashboard/guest.blade.php`.

- `ProfileController.php`
  - **роль**: просмотр/обновление профиля пользователя.
  - **view**: `resources/views/profile/index.blade.php`.

- `ContactController.php`
  - **роль**: страница контактов/карта.
  - **view**: `resources/views/contacts/index.blade.php`.

- `Auth/LoginController.php`
  - **роль**: вход/выход пользователя.
  - **view**: `resources/views/auth/login.blade.php`.

### `app/Models` **[CUSTOM]**

Доменные сущности (таблицы БД + связи).

- `User.php`
  - **роль**: пользователи, роли (admin/manager/master/client), helper-методы `isAdmin()` и т.п.
  - **используется**: контроллеры + blade-проверки ролей.

- `Service.php`
  - **роль**: услуга (название/описание/длительность/цена).

- `Appointment.php`
  - **роль**: запись на услугу (клиент/мастер/дата/статус).
  - **важное**: связи `client/service/master` используются в шаблонах списка записей.

### `app/Http/Middleware` **[CUSTOM]**

- `RoleMiddleware.php`
  - **роль**: проверка доступа по ролям.
  - **как применяется**: в `routes/web.php` через `middleware(['role:admin,manager'])`.
  - **как подключен**: alias `role` регистрируется в `bootstrap/app.php`.

### `app/Providers` **[SYSTEM/MIXED]**

- `AppServiceProvider.php`
  - **роль**: место для глобальных “настроек приложения” (register/boot).
  - **статус сейчас**: методы пустые — провайдер загружается, но ничего не делает (это нормально).

---

## `routes/` — маршрутизация

- `routes/web.php` **[CUSTOM]**
  - **роль**: все URL приложения.
  - **структура**:
    - публичные: `/`, `/services`, `/contacts`
    - auth: `login/logout`
    - защищенные: `dashboard/profile/services/list/appointments`
    - админ/менеджер: `users` resource + `services/manage` CRUD

- `routes/console.php` **[SYSTEM]**
  - **роль**: консольные команды; обычно можно оставить как есть.

---

## `resources/views/` — интерфейс (Blade)

Все эти файлы **[CUSTOM]** и реально используются контроллерами/маршрутами:

- `layouts/app.blade.php` — общий каркас (шапка, footer, подключение темы, `@yield('content')`).
- `partials/salon-theme.blade.php` — общие стили/тема сайта (ваша палитра, кнопки, карточки и т.д.).
- `auth/login.blade.php` — форма входа.
- `dashboard/index.blade.php` — дашборд авторизованного.
- `dashboard/guest.blade.php` — главная для гостя.
- `appointments/index|create|edit.blade.php` — записи.
- `services/public|index|manage|edit.blade.php` — услуги (публичные и управление).
- `users/index|create|edit.blade.php` — управление пользователями.
- `profile/index.blade.php` — профиль.
- `contacts/index.blade.php` — контакты/карта.

---

## `resources/js` и `resources/sass` — исходники фронта

- `resources/js/bootstrap.js` **[SYSTEM/MIXED]**
  - **роль**: базовая настройка axios/CSRF для запросов (типовой файл Laravel).

### Важно про Vite

Файл `vite.config.js` **ссылается на**:
- `resources/sass/app.scss`
- `resources/js/app.js`

Но **в проекте сейчас эти файлы отсутствуют** (и в Blade-шаблонах нет `@vite(...)`), поэтому фронт фактически работает через CDN и встроенные стили.

---

## `database/` — БД (схема и данные)

### `database/migrations` **[CUSTOM+SYSTEM]**

- **[SYSTEM]** `0001_01_01_000000_create_users_table.php` — базовая таблица пользователей.
- **[SYSTEM]** `0001_01_01_000001_create_cache_table.php` — таблица кеша (нужна только если cache-store = database).
- **[SYSTEM]** `0001_01_01_000002_create_jobs_table.php` — таблица очередей (нужна только если queue = database).
- **[CUSTOM]** `2026_03_26_081121_add_role_to_users_table.php` — роли пользователей.
- **[CUSTOM]** `2026_03_26_081153_create_services_table.php` — услуги.
- **[CUSTOM]** `2026_03_26_081202_create_appointments_table.php` — записи.

### `database/seeders` **[CUSTOM]**

- `DatabaseSeeder.php` — основной сидер; вызывает `ServiceSeeder` и создает стартовые аккаунты.
- `ServiceSeeder.php` — наполняет список услуг.

### `database/factories` **[SYSTEM/CUSTOM]**

- `UserFactory.php` — генератор пользователей для тестов/сида через factory.

---

## `config/` — конфигурация (в основном SYSTEM)

Это системные файлы Laravel, которые “управляются” значениями из `.env`.
Самые часто используемые:

- `config/database.php` — подключение к БД.
- `config/auth.php` — настройки аутентификации.
- `config/session.php` / `config/cache.php` / `config/queue.php` — инфраструктура (сессии/кэш/очереди).

---

## `storage/` — runtime (SYSTEM)

Здесь Laravel хранит то, что **создается во время работы**:

- `storage/logs/*` — логи.
- `storage/framework/views/*` — скомпилированные Blade (кэш).
- `storage/framework/sessions/*` — сессии (зависит от драйвера).

Обычно это **не коммитят** и не считают “кодом проекта”.

---

## `vendor/` и `node_modules/`

- `vendor/` **[SYSTEM]**: PHP-библиотеки Composer (Laravel framework и т.д.)
- `node_modules/` **[SYSTEM]**: npm-пакеты (Vite/Bootstrap/Tailwind/axios…)

Их не редактируют руками, ими управляет `composer install` и `npm install`.

---

## Где в проекте “лиды”?

**Сущности “лид” в проекте нет.**

Я проверил по коду ключевые слова `Lead`, `leads`, `лид`, `лиды` — найдено только `"Lead Developer"` внутри `composer.lock` (это метаданные зависимостей, не функциональность CRM).

Если под “лидами” вы имеете в виду потенциальных клиентов (заявки/обращения), то сейчас ближе всего по смыслу:
- **клиенты** (`users` с ролью client),
- **записи** (`appointments`),
- **контакты** (страница `/contacts` без формы заявок).

Чтобы “лиды” появились, нужно добавить минимум: миграцию `leads`, модель `Lead`, контроллер/страницы и маршруты.

