<?php

declare(strict_types=1);

$totalAssets = (int) ($stats['total'] ?? 0);
$operationalCount = (int) ($stats['operational_count'] ?? 0);
$failureCount = (int) ($stats['in_repair_count'] ?? 0) + (int) ($stats['out_of_service_count'] ?? 0);
$due30Days = (int) ($stats['due_30_days'] ?? 0);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) $pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1c520e4603.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>

    <main class="container">
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-industry text-blue" aria-hidden="true"></i>
                    Park Maszynowy i Rejestr Zasobów (EAM)
                </h1>
                <p class="greeting-subtitle">
                    Ewidencja maszyn, historia przeglądów UDT i stan techniczny (PostgreSQL)
                </p>
            </div>
            <div class="flex-row">
                <span class="meta-pill">
                    Łącznie maszyn w bazie: <strong class="text-blue"><?= $totalAssets ?></strong>
                </span>
                <a href="/tickets/add" class="btn-secondary">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Zgłoś awarię
                </a>
                <a href="/assets/add" class="btn-primary">
                    <i class="fa-solid fa-circle-plus" aria-hidden="true"></i> Zarejestruj nową maszynę
                </a>
            </div>
        </header>

        <section class="stats-grid mb-lg" aria-label="Status floty">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywne urządzenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-check-double"></i></span>
                </div>
                <div class="stat-card__value"><?= $operationalCount ?></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Stan operacyjny OK</div>
            </div>

            <div class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Awarie / W naprawie</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                </div>
                <div class="stat-card__value"><?= $failureCount ?></div>
                <div class="stat-card__desc"><i class="fa-solid fa-fire"></i> Wymagana obsługa serwisowa</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy w 30 dni</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-days"></i></span>
                </div>
                <div class="stat-card__value"><?= $due30Days ?></div>
                <div class="stat-card__desc"><i class="fa-solid fa-bell"></i> Dozór UDT i CRON</div>
            </div>
        </section>

        <div class="data-table-container">
            <div class="table-toolbar">
                <form class="table-search" method="GET" action="/assets">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" name="q" value="<?= htmlspecialchars((string) $searchQuery) ?>" placeholder="Szukaj po nazwie, numerze seryjnym, kategorii..." aria-label="Szukaj maszyny">
                </form>
                <div class="table-filters" role="group" aria-label="Filtry kategorii">
                    <a href="/assets" class="filter-btn <?= $activeCategory === '' ? 'active' : '' ?>">Wszystkie</a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="/assets?category=<?= urlencode((string) $cat['name']) ?>" class="filter-btn <?= $activeCategory === $cat['name'] ? 'active' : '' ?>">
                            <?= htmlspecialchars((string) $cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Ewidencja maszyn">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nazwa Urządzenia</th>
                            <th scope="col">Numer Seryjny</th>
                            <th scope="col">Kategoria</th>
                            <th scope="col">Status Techniczny</th>
                            <th scope="col">Następny Przegląd</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($assets)): ?>
                            <tr>
                                <td colspan="7" class="text-muted">Brak maszyn spełniających kryteria.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($assets as $asset): ?>
                                <?php
                                $statusBadge = match ($asset['status']) {
                                    'OUT_OF_SERVICE' => ['badge-red', 'fa-triangle-exclamation', 'AWARIA'],
                                    'IN_REPAIR' => ['badge-amber', 'fa-clock', 'W NAPRAWIE'],
                                    default => ['badge-green', 'fa-check', 'SPRAWNA'],
                                };
                                ?>
                                <tr>
                                    <td class="font-mono">#<?= (int) $asset['id'] ?></td>
                                    <td>
                                        <a href="/assets/<?= (int) $asset['id'] ?>" class="font-bold text-blue"><?= htmlspecialchars((string) $asset['name']) ?></a>
                                        <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars((string) $asset['client_name']) ?>, <?= htmlspecialchars((string) $asset['client_city']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge-serial"><?= htmlspecialchars((string) $asset['serial_number']) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars((string) $asset['category_name']) ?></td>
                                    <td>
                                        <span class="<?= $statusBadge[0] ?>"><i class="fa-solid <?= $statusBadge[1] ?>"></i> <?= $statusBadge[2] ?></span>
                                    </td>
                                    <td><?= htmlspecialchars((string) ($asset['next_inspection_at'] ?? 'Brak danych')) ?></td>
                                    <td class="text-right">
                                        <a href="/assets/<?= (int) $asset['id'] ?>" class="btn-secondary btn-sm">
                                            <i class="fa-solid fa-passport"></i> Paszport EAM
                                        </a>
                                        <?php if (!empty($asset['active_ticket_id'])): ?>
                                            <a href="/tickets/<?= (int) $asset['active_ticket_id'] ?>" class="btn-primary btn-sm">
                                                <i class="fa-solid fa-wrench"></i> Serwis
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
