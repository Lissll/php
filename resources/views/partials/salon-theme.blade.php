<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
:root {
    --salon-font: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
    --salon-cream: #faf5f6;
    --salon-shell: #f3e9ec;
    --salon-ink: #36292e;
    --salon-muted: #6b5a61;

    --bs-primary: #b06d80;
    --bs-primary-rgb: 176, 109, 128;
    --bs-secondary: #8f7a84;
    --bs-secondary-rgb: 143, 122, 132;
    --bs-success: #9b7c89;
    --bs-success-rgb: 155, 124, 137;
    --bs-info: #7d6b75;
    --bs-info-rgb: 125, 107, 117;
    --bs-warning: #c49a6c;
    --bs-warning-rgb: 196, 154, 108;
    --bs-danger: #a85a6b;
    --bs-danger-rgb: 168, 90, 107;

    --bs-body-bg: var(--salon-cream);
    --bs-body-color: var(--salon-ink);
    --bs-border-radius: 0.75rem;
    --bs-border-radius-lg: 1rem;
}

body {
    font-family: var(--salon-font);
    font-weight: 400;
    line-height: 1.55;
    background:
        radial-gradient(ellipse 70% 50% at 10% 0%, rgba(176, 109, 128, 0.08) 0%, transparent 55%),
        radial-gradient(ellipse 60% 45% at 92% 15%, rgba(143, 122, 132, 0.10) 0%, transparent 55%),
        linear-gradient(180deg, var(--salon-cream) 0%, var(--salon-shell) 100%);
    min-height: 100vh;
}

h1, h2, h3, h4, h5, h6,
.navbar-brand,
.display-4,
.display-5,
.display-6 {
    font-family: var(--salon-font);
    font-weight: 600;
    letter-spacing: -0.02em;
}

h1, h2, h3, h4 {
    color: var(--salon-ink);
}

main.container {
    padding-bottom: 3rem;
}

.navbar-salon {
    background: rgba(255, 255, 255, 0.92) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(54, 41, 46, 0.08);
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.8) inset, 0 8px 24px rgba(54, 41, 46, 0.05);
}

.navbar-salon .navbar-brand {
    color: var(--salon-ink) !important;
    font-weight: 700;
    font-size: 1.15rem;
    letter-spacing: -0.03em;
    transform: none;
}

.navbar-salon .navbar-brand i {
    color: var(--bs-primary);
    margin-right: 0.35rem;
}

.navbar-salon .nav-link {
    color: var(--salon-muted) !important;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 0.45rem 0.75rem !important;
    border-radius: 0.5rem;
    transition: color 0.15s, background 0.15s;
}

.navbar-salon .nav-link:hover,
.navbar-salon .nav-link:focus {
    color: var(--salon-ink) !important;
    background: rgba(176, 109, 128, 0.10);
    transform: none;
}

.navbar-salon .nav-link.active {
    color: #fff !important;
    background: linear-gradient(135deg, #b06d80 0%, #9a5f72 100%);
    box-shadow: 0 4px 12px rgba(176, 109, 128, 0.22);
}

.navbar-salon .btn-link.nav-link {
    color: var(--salon-muted) !important;
    text-decoration: none;
}

.navbar-salon .btn-link.nav-link:hover {
    color: var(--bs-danger) !important;
    background: rgba(168, 90, 107, 0.08);
}

.navbar-salon .navbar-toggler {
    border-color: rgba(176, 109, 128, 0.35);
}

.navbar-salon .navbar-toggler-icon {
    filter: none;
    opacity: 0.7;
}

.footer-salon {
    margin-top: auto;
    padding: 2rem 0 1.75rem;
    background: linear-gradient(180deg, #4a3e42 0%, #3a3235 100%);
    color: rgba(255, 255, 255, 0.82);
    text-align: center;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
}

.footer-salon .text-muted {
    color: rgba(255, 255, 255, 0.45) !important;
}

.card {
    border: 1px solid rgba(54, 41, 46, 0.08);
    border-radius: var(--bs-border-radius-lg);
    box-shadow: 0 4px 20px rgba(54, 41, 46, 0.06);
    overflow: hidden;
    background: #fff;
}

.card-header {
    font-family: var(--salon-font);
    font-weight: 600;
    border-bottom: 1px solid rgba(54, 41, 46, 0.07);
}

.card-header.bg-primary.text-white {
    background: linear-gradient(135deg, #a86278 0%, #8f5568 100%) !important;
    border: none !important;
}

.card-header.bg-success.text-white {
    background: linear-gradient(135deg, #8f7380 0%, #7a6672 100%) !important;
    border: none !important;
}

.card-header.bg-info.text-white {
    background: linear-gradient(135deg, #756875 0%, #645a65 100%) !important;
    border: none !important;
}

.card-header.bg-warning.text-white,
.card-header.bg-warning {
    background: linear-gradient(135deg, #c9a882 0%, #b8926a 100%) !important;
    color: #2e2520 !important;
    border: none !important;
}

.card-footer.bg-transparent {
    border-top: 1px solid rgba(54, 41, 46, 0.06);
}

.btn {
    font-family: var(--salon-font);
    font-weight: 600;
    border-radius: 0.6rem;
    padding: 0.5rem 1.1rem;
    letter-spacing: -0.01em;
}

.btn-primary {
    border: none;
    background: linear-gradient(135deg, #b06d80 0%, #9a5f72 100%);
    box-shadow: 0 4px 14px rgba(176, 109, 128, 0.28);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #9d6174 0%, #865465 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(176, 109, 128, 0.32);
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-secondary:hover,
.btn-outline-dark:hover {
    transform: translateY(-1px);
}

.form-control,
.form-select {
    border-radius: 0.6rem;
    border: 1px solid rgba(54, 41, 46, 0.14);
    padding: 0.5rem 0.85rem;
}

.form-control:focus,
.form-select:focus {
    border-color: rgba(176, 109, 128, 0.55);
    box-shadow: 0 0 0 0.2rem rgba(176, 109, 128, 0.15);
}

.alert {
    border: 1px solid rgba(54, 41, 46, 0.06);
    border-radius: var(--bs-border-radius);
}

.table thead.table-dark th {
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge,
.status-pending,
.status-confirmed,
.status-completed,
.status-cancelled {
    display: inline-block;
    padding: 0.3rem 0.65rem;
    border-radius: 2rem;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}

.status-pending {
    background: rgba(196, 154, 108, 0.25);
    color: #5c4528;
}

.status-confirmed {
    background: rgba(125, 107, 117, 0.25);
    color: #3d3539;
}

.status-completed {
    background: rgba(109, 143, 114, 0.22);
    color: #2f4334;
}

.status-cancelled {
    background: rgba(168, 90, 107, 0.20);
    color: #5c2f38;
}

.hero-salon {
    position: relative;
    background: linear-gradient(135deg, #e8d2d9 0%, #dcc0ca 45%, #cfaebb 100%);
    color: var(--salon-ink);
    padding: 4rem 0 3.5rem;
    margin-bottom: 2.5rem;
    overflow: hidden;
}

.hero-salon::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 18% 24%, rgba(255, 255, 255, 0.45) 0 14%, transparent 15%),
        radial-gradient(circle at 78% 30%, rgba(255, 255, 255, 0.22) 0 12%, transparent 13%);
    pointer-events: none;
}

.hero-salon .container {
    position: relative;
    z-index: 1;
}

.hero-salon h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.03em;
}

.hero-salon .lead {
    font-weight: 400;
    opacity: 0.88;
    font-size: 1.05rem;
    max-width: 36rem;
    margin-left: auto;
    margin-right: auto;
}

.hero-salon .btn-light {
    background: #fff;
    border: 1px solid rgba(54, 41, 46, 0.1);
    color: var(--salon-ink);
    font-weight: 600;
    padding: 0.65rem 1.5rem;
    border-radius: 0.65rem;
    box-shadow: 0 6px 20px rgba(54, 41, 46, 0.08);
}

.hero-salon .btn-light:hover {
    background: var(--salon-cream);
    color: var(--bs-primary);
}

.service-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border-radius: var(--bs-border-radius-lg) !important;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(54, 41, 46, 0.1) !important;
}

.service-card .text-primary {
    color: var(--bs-primary) !important;
}

.page-heading {
    font-family: var(--salon-font);
    font-weight: 600;
    color: var(--salon-ink);
    margin-bottom: 1rem;
    letter-spacing: -0.03em;
}

.auth-card .card-header {
    background: linear-gradient(135deg, #a86278 0%, #7d5564 100%) !important;
    color: #fff !important;
    border: none;
    padding: 1.15rem 1.35rem;
}

.auth-card .card-header h4,
.auth-card .card-header small {
    color: #fff !important;
}

.auth-card .card-header small {
    display: block;
    margin-top: 0.2rem;
    font-weight: 400;
    opacity: 0.9;
    font-size: 0.88rem;
}

.auth-card .card-body {
    padding: 1.5rem;
}

.manager-action-btn {
    border-radius: 0.6rem !important;
}

.quick-actions .btn {
    border-color: rgba(176, 109, 128, 0.5);
    color: var(--bs-primary);
    background: rgba(176, 109, 128, 0.05);
}

.quick-actions .btn:hover,
.quick-actions .btn:focus {
    border-color: transparent;
    color: #fff;
    background: linear-gradient(135deg, #b06d80 0%, #9a5f72 100%);
}

.dash-welcome-card {
    background: linear-gradient(120deg, #9d6274 0%, #8a5566 50%, #744a59 100%) !important;
    border: none !important;
    color: #fff !important;
    box-shadow: 0 8px 28px rgba(116, 74, 89, 0.25) !important;
}

.dash-welcome-card h4,
.dash-welcome-card p {
    color: #fff !important;
}

.dash-welcome-card p {
    opacity: 0.93;
    font-weight: 400;
}

.stat-card-soft {
    border: none !important;
    border-radius: var(--bs-border-radius-lg) !important;
    box-shadow: 0 8px 24px rgba(54, 41, 46, 0.12) !important;
    color: #fff !important;
}

.stat-card-soft .card-body {
    color: #fff !important;
}

.stat-card-soft h5,
.stat-card-soft h5.card-title {
    color: rgba(255, 255, 255, 0.96) !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
}

.stat-card-soft.bg-info {
    background: linear-gradient(145deg, #7a6a74 0%, #655a63 100%) !important;
}

.stat-card-soft.bg-warning {
    background: linear-gradient(145deg, #9c7f8a 0%, #846e78 100%) !important;
}

.stat-card-soft.bg-success {
    background: linear-gradient(145deg, #8b7280 0%, #73606c 100%) !important;
}

.stat-card-soft.bg-primary {
    background: linear-gradient(145deg, #b06d80 0%, #915d6e 100%) !important;
}

.stat-card-soft.bg-secondary {
    background: linear-gradient(145deg, #6d5e66 0%, #5a4d54 100%) !important;
}

.stat-card-soft.bg-dark {
    background: linear-gradient(145deg, #4f4449 0%, #3d3539 100%) !important;
}

.stat-card-soft h5 {
    font-family: var(--salon-font);
    font-size: 0.8rem;
    font-weight: 700;
    opacity: 1;
    text-transform: uppercase;
    letter-spacing: 0.07em;
}

.stat-card-soft .display-4 {
    font-family: var(--salon-font);
    font-weight: 700;
    letter-spacing: -0.03em;
    line-height: 1.1;
    color: #fff !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Страница «Контакты» + карта */
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

.contacts-map-widget {
    flex: 1;
    min-height: 720px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(46, 42, 45, 0.08);
}

.contacts-map-widget iframe {
    display: block;
    border: 0;
    min-height: 420px;
}

@media (max-width: 767.98px) {
    #map,
    .contacts-map-widget {
        min-height: 420px;
    }
}

.table-dark {
    --bs-table-bg: #4a4145;
    --bs-table-border-color: rgba(255, 255, 255, 0.07);
}
</style>
