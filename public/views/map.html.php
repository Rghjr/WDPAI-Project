<?php

declare(strict_types=1);

$activeTechs = (int) ($userStats['active_technicians'] ?? 0);
$openCount = (int) ($ticketStats['open_count'] ?? 0);
$criticalCount = (int) ($ticketStats['critical_count'] ?? 0);
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
        <header class="card-block mb-lg">
            <div class="flex-between flex-wrap gap-md">
                <div class="flex-row gap-sm">
                    <span class="meta-pill green">
                        <span class="status-dot"></span> Lokalizacje klientów (PostgreSQL GIS)
                    </span>
                </div>
                <div class="flex-row flex-wrap gap-md">
                    <div class="meta-pill">
                        <span><strong><?= $activeTechs ?> Techników aktywnych</strong></span>
                    </div>
                    <div class="meta-pill">
                        <span>Otwarte zgłoszenia: <strong><?= $openCount ?></strong> (Krytyczne: <strong class="text-red"><?= $criticalCount ?></strong>)</span>
                    </div>
                </div>
                <div class="flex-row">
                    <a href="/tickets/add" class="btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Nowe zlecenie #WO
                    </a>
                </div>
            </div>
        </header>

        <section class="data-table-container">
            <div class="table-responsive">
                <table class="data-table" aria-label="Mapa obiektów i lokalizacji klientów">
                    <thead>
                        <tr>
                            <th scope="col">Obiekt / Klient</th>
                            <th scope="col">Miasto &amp; Adres</th>
                            <th scope="col">Współrzędne GPS</th>
                            <th scope="col">Liczba maszyn</th>
                            <th scope="col">Aktywne awarie</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locations as $loc): ?>
                            <tr>
                                <td class="font-bold"><?= htmlspecialchars((string) $loc['name']) ?></td>
                                <td><?= htmlspecialchars((string) $loc['city']) ?>, <?= htmlspecialchars((string) $loc['address']) ?></td>
                                <td class="font-mono text-xs">
                                    <?= htmlspecialchars((string) ($loc['latitude'] ?? '—')) ?>, <?= htmlspecialchars((string) ($loc['longitude'] ?? '—')) ?>
                                </td>
                                <td><strong><?= (int) $loc['asset_count'] ?></strong></td>
                                <td>
                                    <?php if ((int) $loc['active_tickets_count'] > 0): ?>
                                        <span class="badge-red"><?= (int) $loc['active_tickets_count'] ?> aktywne</span>
                                    <?php else: ?>
                                        <span class="badge-green">0</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a href="/assets?q=<?= urlencode((string) $loc['city']) ?>" class="btn-secondary btn-sm">Maszyny</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
