<?php

declare(strict_types=1);

$assetId = (int) $asset['id'];
$statusBadge = match ($asset['status']) {
    'OUT_OF_SERVICE' => ['badge-red', 'fa-triangle-exclamation', 'AWARIA / WYŁĄCZONA Z EKSPLOATACJI'],
    'IN_REPAIR' => ['badge-amber', 'fa-clock', 'W TRAKCIE NAPRAWY'],
    default => ['badge-green', 'fa-circle-check', 'STAN OPERACYJNY PRAWIDŁOWY'],
};
$nextInspection = $asset['next_inspection_at'] ?? null;
$isInspectionSoon = $nextInspection !== null && strtotime((string) $nextInspection) < strtotime('+14 days');
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
        <div class="asset-context-bar mb-md">
            <div class="flex-row gap-xs text-xs text-muted">
                <a href="/assets" class="text-muted hover-underline">Park maszynowy</a>
                <span class="text-dim">/</span>
                <span class="text-muted"><?= htmlspecialchars((string) $asset['category_name']) ?></span>
                <span class="text-dim">/</span>
                <span class="font-mono bg-card px-xs py-0.5 rounded text-main font-semibold">SN: <?= htmlspecialchars((string) $asset['serial_number']) ?></span>
            </div>
            <div class="flex-row gap-xs font-mono text-xs">
                <span class="text-muted">Paszport EAM:</span>
                <span class="font-bold text-main">#<?= $assetId ?></span>
            </div>
        </div>

        <header class="card-block mb-lg">
            <div class="flex-between flex-wrap gap-md">
                <div>
                    <div class="flex-row flex-wrap gap-sm mb-xs">
                        <h1 class="text-xl font-extrabold text-main">
                            <?= htmlspecialchars((string) $asset['name']) ?>
                        </h1>
                        <?php if (!empty($asset['model'])): ?>
                            <span class="text-muted text-sm font-normal">• <?= htmlspecialchars((string) $asset['model']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="flex-row flex-wrap gap-xs">
                        <span class="<?= $statusBadge[0] ?>"><i class="fa-solid <?= $statusBadge[1] ?>"></i> <?= $statusBadge[2] ?></span>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-tag"></i> Kategoria: <?= htmlspecialchars((string) $asset['category_name']) ?>
                        </span>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars((string) $asset['client_name']) ?> (<?= htmlspecialchars((string) $asset['client_city']) ?>)
                        </span>
                    </div>
                </div>

                <div class="flex-row flex-wrap gap-sm">
                    <button type="button" class="btn-secondary btn-sm" onclick="window.print()">
                        <i class="fa-solid fa-file-pdf"></i> Drukuj paszport DTR
                    </button>
                    <a href="/tickets/add" class="btn-primary btn-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i> Nowe zgłoszenie awarii
                    </a>
                </div>
            </div>
        </header>

        <div class="detail-layout">
            <div class="detail-main">
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <h2><i class="fa-solid fa-sliders text-blue" aria-hidden="true"></i> Metryka Fabryczna i Parametry Robocze (DTR)</h2>
                        <span class="meta-pill text-xs">Paszport EAM #<?= $assetId ?></span>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Producent urządzenia</div>
                            <div class="meta-value font-bold"><?= htmlspecialchars((string) ($asset['manufacturer'] ?? 'Brak danych')) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Model i wariant</div>
                            <div class="meta-value"><?= htmlspecialchars((string) ($asset['model'] ?? 'Brak danych')) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Rok produkcji</div>
                            <div class="meta-value"><?= htmlspecialchars((string) ($asset['production_year'] ?? 'Brak danych')) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Przepracowane motogodziny</div>
                            <div class="meta-value text-blue font-bold font-mono"><?= number_format((float) ($asset['operating_hours'] ?? 0), 0, ',', ' ') ?> h</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Adres klienta</div>
                            <div class="meta-value"><?= htmlspecialchars((string) $asset['client_address']) ?>, <?= htmlspecialchars((string) $asset['client_city']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Lokalizacja na obiekcie</div>
                            <div class="meta-value text-xs text-muted"><i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars((string) ($asset['location_details'] ?? 'Brak danych')) ?></div>
                        </div>
                    </div>
                </article>

                <section class="card-block">
                    <div class="flex-between mb-md">
                        <h2><i class="fa-solid fa-shield-halved text-amber" aria-hidden="true"></i> Status Dozoru Technicznego (UDT)</h2>
                        <a href="/schedule?tab=udt" class="btn-secondary btn-sm">
                            <i class="fa-solid fa-calendar-check"></i> Terminarz UDT
                        </a>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Numer księgi rewizyjnej UDT</div>
                            <div class="meta-value font-mono font-bold"><?= htmlspecialchars((string) ($asset['udt_number'] ?? 'Nie podlega UDT')) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Ostatnie badanie okresowe</div>
                            <div class="meta-value"><?= htmlspecialchars((string) ($asset['last_inspection_at'] ?? 'Brak danych')) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Termin kolejnego przeglądu</div>
                            <div class="meta-value font-bold <?= $isInspectionSoon ? 'text-red' : 'text-green' ?>">
                                <i class="fa-solid fa-calendar-day"></i> <?= htmlspecialchars((string) ($nextInspection ?? 'Brak terminu')) ?>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Decyzja eksploatacyjna UDT</div>
                            <div class="meta-value text-green font-bold">
                                <?= !empty($asset['udt_valid_until']) ? 'Ważna do: ' . htmlspecialchars((string) $asset['udt_valid_until']) : 'Nie dotyczy' ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="detail-sidebar">
                <div class="card-block mb-lg">
                    <h2><i class="fa-solid fa-user-gear text-blue" aria-hidden="true"></i> Opiekun techniczny</h2>
                    <div class="asset-meta-list">
                        <div class="flex-between">
                            <span class="text-muted">Technik prowadzący:</span>
                            <strong><?= htmlspecialchars(trim((string) ($asset['technician_name'] ?? '')) ?: 'Nieprzypisany') ?></strong>
                        </div>
                        <?php if (!empty($asset['technician_code'])): ?>
                            <div class="flex-between">
                                <span class="text-muted">Kod pracownika:</span>
                                <span class="font-mono"><?= htmlspecialchars((string) $asset['technician_code']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($asset['active_ticket_id'])): ?>
                        <div class="mt-md pt-md border-top">
                            <a href="/tickets/<?= (int) $asset['active_ticket_id'] ?>" class="btn-primary btn-full">
                                <i class="fa-solid fa-wrench" aria-hidden="true"></i> Aktywne zlecenie #WO-<?= (int) $asset['active_ticket_id'] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
