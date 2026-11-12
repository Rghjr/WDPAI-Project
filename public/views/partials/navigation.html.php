<?php

declare(strict_types=1);

$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($currentUri, PHP_URL_PATH) ?: '/';
?>
<nav class="site-navigation" aria-label="Nawigacja główna">
    <div class="site-navigation__brand-wrapper">
        <a class="site-navigation__brand" href="/">
            <span class="brand-icon"><i class="fa-solid fa-gears" aria-hidden="true"></i></span>
            <span class="brand-text">AssetFix<span class="brand-accent">.AI</span></span>
        </a>
        <span class="brand-badge">Enterprise Core</span>
    </div>

    <ul class="site-navigation__links">
        <li>
            <a href="/" class="<?= ($path === '/' ? 'active' : '') ?>">
                <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                <span>Pulpit</span>
            </a>
        </li>
        <li>
            <a href="/tickets" class="<?= (str_starts_with($path, '/tickets') && $path !== '/tickets/add' ? 'active' : '') ?>">
                <i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>
                <span>Zgłoszenia</span>
                <span class="nav-counter">3</span>
            </a>
        </li>
        <li>
            <a href="/assets" class="<?= (str_starts_with($path, '/assets') ? 'active' : '') ?>">
                <i class="fa-solid fa-industry" aria-hidden="true"></i>
                <span>Park maszynowy</span>
            </a>
        </li>
        <li>
            <a href="/maintenance" class="<?= ($path === '/maintenance' ? 'active' : '') ?>">
                <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                <span>Przeglądy EAM</span>
            </a>
        </li>
        <li>
            <a href="/admin/users" class="<?= ($path === '/admin/users' ? 'active' : '') ?>">
                <i class="fa-solid fa-users-gear" aria-hidden="true"></i>
                <span>Zespół</span>
            </a>
        </li>
    </ul>

    <div class="site-navigation__actions">
        <div class="system-status-indicator" title="Status łączności z infrastrukturą">
            <span class="status-dot"></span>
            <span class="status-label">Baza Poznań • IoT Hub 99.9%</span>
        </div>

        <button class="theme-toggle" type="button" aria-label="Włącz ciemny motyw" aria-pressed="false">
            <span class="theme-toggle__icon" aria-hidden="true">☾</span>
        </button>

        <a href="/profile" class="user-pill <?= ($path === '/profile' ? 'active' : '') ?>" title="Karta i profil serwisanta (Piotr Kowalski)">
            <span class="user-pill__avatar"><i class="fa-solid fa-user-gear" aria-hidden="true"></i></span>
            <span class="user-pill__name">Piotr Kowalski</span>
        </a>
    </div>
</nav>
<script src="/js/theme.js" defer></script>
