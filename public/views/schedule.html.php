<?php

declare(strict_types=1);

$dueUdtInSevenDays = (int) ($assetStats['due_7_days'] ?? 0);
$dueUdtInThirtyDays = (int) ($assetStats['due_30_days'] ?? 0);
$activeTicketsCount = (int) ($ticketStats['active_count'] ?? 0);
$totalTicketsCount = (int) ($ticketStats['total'] ?? 0);
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
                    <i class="fa-solid fa-calendar-days text-blue" aria-hidden="true"></i>
                    Harmonogram i Dyspozycja Zespołu UR
                </h1>
                <p class="greeting-subtitle">
                    Planowanie zleceń serwisowych oraz terminarz przeglądów okresowych UDT (PostgreSQL)
                </p>
            </div>
            <div class="flex-row flex-wrap gap-sm">
                <div class="view-tab-pill-group">
                    <a href="/schedule?tab=dispatch" class="view-tab-btn <?= ($activeTab !== 'udt' ? 'active' : '') ?>">
                        <i class="fa-solid fa-users"></i> Zaplanowane zlecenia (<?= count($scheduledTickets) ?>)
                    </a>
                    <a href="/schedule?tab=udt" class="view-tab-btn <?= ($activeTab === 'udt' ? 'active' : '') ?>">
                        <i class="fa-solid fa-shield-halved"></i> Dozór UDT &amp; CRON (<?= $dueUdtInSevenDays ?> pilne)
                    </a>
                </div>
            </div>
        </header>

        <section class="stats-grid mb-lg" aria-label="Wskaźniki dyspozycji">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywne zlecenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-check"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= $activeTicketsCount ?> / <?= $totalTicketsCount ?></div>
                <div class="stat-card__desc text-muted">Otwarte i w toku realizacji</div>
            </div>

            <div class="stat-card <?= ($dueUdtInSevenDays > 0 ? 'critical' : '') ?>">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy UDT (&le; 7 dni)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-bell"></i></span>
                </div>
                <div class="stat-card__value text-red"><?= $dueUdtInSevenDays ?></div>
                <div class="stat-card__desc text-red"><i class="fa-solid fa-triangle-exclamation"></i> Zakres dziennego zadania CRON</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy w 30 dni</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-shield-halved"></i></span>
                </div>
                <div class="stat-card__value text-amber"><?= $dueUdtInThirtyDays ?></div>
                <div class="stat-card__desc text-muted">Nadchodzące inspekcje</div>
            </div>
        </section>

        <?php if ($activeTab === 'udt'): ?>
            <section class="data-table-container">
                <div class="table-responsive">
                    <table class="data-table" aria-label="Harmonogram przeglądów UDT">
                        <thead>
                            <tr>
                                <th scope="col">Maszyna &amp; S/N</th>
                                <th scope="col">Klient</th>
                                <th scope="col">Nr UDT</th>
                                <th scope="col">Termin przeglądu</th>
                                <th scope="col">Pozostało dni</th>
                                <th scope="col">Opiekun</th>
                                <th scope="col" class="text-right">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcomingInspections as $insp): ?>
                                <?php $days = (int) $insp['days_until_inspection']; ?>
                                <tr>
                                    <td>
                                        <a href="/assets/<?= (int) $insp['asset_id'] ?>" class="font-bold text-blue"><?= htmlspecialchars((string) $insp['asset_name']) ?></a>
                                        <div class="text-xs font-mono text-muted"><?= htmlspecialchars((string) $insp['serial_number']) ?></div>
                                    </td>
                                    <td><?= htmlspecialchars((string) $insp['client_name']) ?> (<?= htmlspecialchars((string) $insp['client_city']) ?>)</td>
                                    <td class="font-mono text-xs"><?= htmlspecialchars((string) ($insp['udt_number'] ?? '—')) ?></td>
                                    <td class="font-mono"><?= htmlspecialchars((string) $insp['next_inspection_at']) ?></td>
                                    <td>
                                        <span class="<?= $days <= 7 ? 'badge-red' : ($days <= 30 ? 'badge-amber' : 'badge-green') ?>">
                                            <?= $days < 0 ? 'Przeterminowany (' . abs($days) . ' dni)' : $days . ' dni' ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars(trim((string) ($insp['technician_name'] ?? '')) ?: 'Nieprzypisany') ?></td>
                                    <td class="text-right">
                                        <a href="/assets/<?= (int) $insp['asset_id'] ?>" class="btn-secondary btn-sm">Paszport EAM</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php else: ?>
            <section class="data-table-container">
                <div class="table-responsive">
                    <table class="data-table" aria-label="Zaplanowane zlecenia serwisowe">
                        <thead>
                            <tr>
                                <th scope="col">Zlecenie</th>
                                <th scope="col">Maszyna &amp; Klient</th>
                                <th scope="col">Priorytet</th>
                                <th scope="col">Status</th>
                                <th scope="col">Technik</th>
                                <th scope="col" class="text-right">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scheduledTickets as $item): ?>
                                <tr>
                                    <td><a href="/tickets/<?= (int) $item['id'] ?>" class="ticket-code">#WO-<?= (int) $item['id'] ?></a></td>
                                    <td>
                                        <div class="font-semibold"><?= htmlspecialchars((string) $item['title']) ?></div>
                                        <div class="text-xs text-muted"><?= htmlspecialchars((string) $item['asset_name']) ?> • <?= htmlspecialchars((string) $item['client_city']) ?></div>
                                    </td>
                                    <td><span class="badge-amber"><?= htmlspecialchars((string) $item['priority']) ?></span></td>
                                    <td><span class="badge-blue"><?= htmlspecialchars((string) $item['status']) ?></span></td>
                                    <td><?= htmlspecialchars(trim((string) ($item['technician_name'] ?? '')) ?: 'Nieprzypisane') ?></td>
                                    <td class="text-right">
                                        <a href="/tickets/<?= (int) $item['id'] ?>" class="btn-secondary btn-sm">Szczegóły</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
