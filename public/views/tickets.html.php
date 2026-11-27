<?php

declare(strict_types=1);

$activeCount = (int) ($stats['active_count'] ?? 0);
$totalCount = (int) ($stats['total'] ?? 0);
$openCount = (int) ($stats['open_count'] ?? 0);
$inProgressCount = (int) ($stats['in_progress_count'] ?? 0);
$resolvedCount = (int) ($stats['resolved_count'] ?? 0);
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
                    <i class="fa-solid fa-clipboard-list text-blue" aria-hidden="true"></i>
                    Rejestr Zgłoszeń i Zleceń Serwisowych
                </h1>
                <p class="greeting-subtitle">
                    Zarządzanie incydentami, naprawami i predykcyjną diagnostyką maszyn (PostgreSQL)
                </p>
            </div>
            <div class="flex-row">
                <span class="meta-pill">
                    Aktywne zgłoszenia: <strong class="text-blue"><?= $activeCount ?></strong>
                </span>
                <a href="/tickets/add" class="btn-primary">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Dodaj nowe zgłoszenie
                </a>
            </div>
        </header>

        <div class="data-table-container">
            <div class="table-toolbar">
                <form class="table-search" method="GET" action="/tickets">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" name="q" value="<?= htmlspecialchars((string) $searchQuery) ?>" placeholder="Szukaj po tytule, maszynie, S/N lub kliencie..." aria-label="Wyszukaj zlecenie">
                </form>
                <div class="table-filters" role="group" aria-label="Filtry statusu">
                    <a href="/tickets" class="filter-btn <?= $activeStatus === null && $activeFilter === null ? 'active' : '' ?>">Wszystkie (<?= $totalCount ?>)</a>
                    <a href="/tickets?status=OPEN" class="filter-btn <?= $activeStatus === 'OPEN' ? 'active' : '' ?>">Otwarte (<?= $openCount ?>)</a>
                    <a href="/tickets?status=IN_PROGRESS" class="filter-btn <?= $activeStatus === 'IN_PROGRESS' ? 'active' : '' ?>">W toku (<?= $inProgressCount ?>)</a>
                    <a href="/tickets?status=RESOLVED" class="filter-btn <?= $activeStatus === 'RESOLVED' ? 'active' : '' ?>">Rozwiązane (<?= $resolvedCount ?>)</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Lista zleceń serwisowych">
                    <thead>
                        <tr>
                            <th scope="col">Kod Zlecenia</th>
                            <th scope="col">Urządzenie &amp; S/N</th>
                            <th scope="col">Tytuł Usterki</th>
                            <th scope="col">Priorytet</th>
                            <th scope="col">Status</th>
                            <th scope="col">Przypisany</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tickets)): ?>
                            <tr>
                                <td colspan="7" class="text-muted">Brak zgłoszeń spełniających kryteria.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <?php
                                $priorityBadge = match ($ticket['priority']) {
                                    'CRITICAL' => ['badge-red', 'fa-fire', 'KRYTYCZNY'],
                                    'HIGH' => ['badge-amber', 'fa-triangle-exclamation', 'WYSOKI'],
                                    'MEDIUM' => ['badge-blue', 'fa-circle-info', 'ŚREDNI'],
                                    default => ['badge-green', 'fa-circle-check', 'NISKI'],
                                };
                                $statusBadge = match ($ticket['status']) {
                                    'IN_PROGRESS' => ['badge-amber', 'fa-clock', 'W trakcie'],
                                    'RESOLVED' => ['badge-green', 'fa-check', 'Rozwiązane'],
                                    'CLOSED' => ['badge-green', 'fa-lock', 'Zamknięte'],
                                    default => ['badge-blue', 'fa-envelope-open', 'Otwarte'],
                                };
                                ?>
                                <tr>
                                    <td>
                                        <a href="/tickets/<?= (int) $ticket['id'] ?>" class="ticket-code">
                                            #WO-<?= (int) $ticket['id'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="font-semibold"><?= htmlspecialchars((string) $ticket['asset_name']) ?></div>
                                        <span class="badge-serial"><?= htmlspecialchars((string) $ticket['asset_serial_number']) ?></span>
                                    </td>
                                    <td>
                                        <div class="font-semibold"><?= htmlspecialchars((string) $ticket['title']) ?></div>
                                        <?php if (!empty($ticket['ai_suggestion'])): ?>
                                            <span class="text-muted text-xs"><i class="fa-solid fa-wand-magic-sparkles text-ai"></i> Smart Diagnosis dostępna</span>
                                        <?php else: ?>
                                            <span class="text-muted text-xs"><?= htmlspecialchars((string) $ticket['client_name']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="<?= $priorityBadge[0] ?>"><i class="fa-solid <?= $priorityBadge[1] ?>" aria-hidden="true"></i> <?= $priorityBadge[2] ?></span>
                                    </td>
                                    <td>
                                        <span class="<?= $statusBadge[0] ?>"><i class="fa-solid <?= $statusBadge[1] ?>" aria-hidden="true"></i> <?= $statusBadge[2] ?></span>
                                    </td>
                                    <td>
                                        <div class="flex-row gap-xs">
                                            <span class="user-pill__avatar"><i class="fa-solid fa-user"></i></span>
                                            <span><?= htmlspecialchars(trim((string) ($ticket['technician_name'] ?? '')) ?: 'Nieprzypisane') ?></span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a href="/tickets/<?= (int) $ticket['id'] ?>" class="btn-secondary btn-sm">
                                            Szczegóły <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                        </a>
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
