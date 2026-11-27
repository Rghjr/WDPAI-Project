<?php

declare(strict_types=1);

$assetId = $asset->id;
$isInspectionSoon = $asset->isInspectionSoon();
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
                <span class="text-muted"><?= htmlspecialchars($asset->categoryName) ?></span>
                <span class="text-dim">/</span>
                <span class="font-mono bg-card px-xs py-0.5 rounded text-main font-semibold">SN: <?= htmlspecialchars($asset->serialNumber) ?></span>
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
                            <?= htmlspecialchars($asset->name) ?>
                        </h1>
                        <?php if ($asset->model !== null && $asset->model !== ''): ?>
                            <span class="text-muted text-sm font-normal">• <?= htmlspecialchars($asset->model) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="flex-row flex-wrap gap-xs">
                        <span class="<?= $asset->status->badgeClass() ?>"><i class="fa-solid <?= $asset->status->iconClass() ?>"></i> <?= htmlspecialchars($asset->status->label()) ?></span>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-tag"></i> Kategoria: <?= htmlspecialchars($asset->categoryName) ?>
                        </span>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars($asset->clientName) ?> (<?= htmlspecialchars($asset->clientCity) ?>)
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
                            <div class="meta-value font-bold"><?= htmlspecialchars($asset->manufacturer ?? 'Brak danych') ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Model i wariant</div>
                            <div class="meta-value"><?= htmlspecialchars($asset->model ?? 'Brak danych') ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Rok produkcji</div>
                            <div class="meta-value"><?= htmlspecialchars($asset->productionYear !== null ? (string) $asset->productionYear : 'Brak danych') ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Przepracowane motogodziny</div>
                            <div class="meta-value text-blue font-bold font-mono"><?= number_format((float) $asset->operatingHours, 0, ',', ' ') ?> h</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Adres klienta</div>
                            <div class="meta-value"><?= htmlspecialchars($asset->clientAddress) ?>, <?= htmlspecialchars($asset->clientCity) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Lokalizacja na obiekcie</div>
                            <div class="meta-value text-xs text-muted"><i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars($asset->locationDetails ?? 'Brak danych') ?></div>
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
                            <div class="meta-value font-mono font-bold"><?= htmlspecialchars($asset->udtNumber ?? 'Nie podlega UDT') ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Ostatnie badanie okresowe</div>
                            <div class="meta-value"><?= htmlspecialchars($asset->lastInspectionAt ?? 'Brak danych') ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Termin kolejnego przeglądu</div>
                            <div class="meta-value font-bold <?= $isInspectionSoon ? 'text-red' : 'text-green' ?>">
                                <i class="fa-solid fa-calendar-day"></i> <?= htmlspecialchars($asset->nextInspectionAt ?? 'Brak terminu') ?>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Decyzja eksploatacyjna UDT</div>
                            <div class="meta-value text-green font-bold">
                                <?= $asset->udtValidUntil !== null ? 'Ważna do: ' . htmlspecialchars($asset->udtValidUntil) : 'Nie dotyczy' ?>
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
                            <strong><?= htmlspecialchars($asset->technicianName) ?></strong>
                        </div>
                        <?php if ($asset->technicianCode !== null): ?>
                            <div class="flex-between">
                                <span class="text-muted">Kod pracownika:</span>
                                <span class="font-mono"><?= htmlspecialchars($asset->technicianCode) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($asset->activeTicketId !== null): ?>
                        <div class="mt-md pt-md border-top">
                            <a href="/tickets/<?= $asset->activeTicketId ?>" class="btn-primary btn-full">
                                <i class="fa-solid fa-wrench" aria-hidden="true"></i> Aktywne zlecenie #WO-<?= $asset->activeTicketId ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
