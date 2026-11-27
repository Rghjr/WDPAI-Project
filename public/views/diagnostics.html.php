<?php

declare(strict_types=1);

$activeCount = (int) ($ticketStats['active_count'] ?? 0);
$criticalCount = (int) ($ticketStats['critical_count'] ?? 0);
$totalAssets = (int) ($assetStats['total'] ?? 0);
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
        <?php if ($criticalIncident !== null): ?>
            <section class="ai-p1-banner mb-lg">
                <div class="ai-p1-accent-stripe"></div>
                <div class="ai-p1-content">
                    <div class="flex-row gap-md">
                        <div class="ai-p1-icon-badge">
                            <i class="fa-solid fa-triangle-exclamation text-red text-xl"></i>
                        </div>
                        <div>
                            <div class="flex-row flex-wrap gap-xs mb-xs">
                                <span class="badge-red text-xs font-bold uppercase tracking-wider">Priorytetowy Incydent #WO-<?= $criticalIncident->id ?></span>
                                <span class="font-mono text-xs font-semibold"><?= htmlspecialchars($criticalIncident->assetSerialNumber) ?></span>
                                <span class="text-muted">•</span>
                                <span class="text-xs text-muted"><?= htmlspecialchars($criticalIncident->clientName) ?> (<?= htmlspecialchars($criticalIncident->clientCity) ?>)</span>
                            </div>
                            <h1 class="text-lg font-extrabold text-main leading-tight">
                                <?= htmlspecialchars($criticalIncident->title) ?>
                            </h1>
                        </div>
                    </div>

                    <div class="ai-p1-actions">
                        <a href="/tickets/<?= $criticalIncident->id ?>" class="btn-primary btn-sm">
                            <i class="fa-solid fa-wrench"></i> Otwórz zgłoszenie
                        </a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="stats-grid mb-lg" aria-label="Wskaźniki AI">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Zgłoszenia z diagnozą AI</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-brain"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= count($aiDiagnosedTickets) ?></div>
                <div class="stat-card__desc text-muted">Zapisane w bazie PostgreSQL</div>
            </div>

            <div class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Incydenty Krytyczne</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-bug"></i></span>
                </div>
                <div class="stat-card__value text-red"><?= $criticalCount ?></div>
                <div class="stat-card__desc text-red">Wymagana pilna interwencja</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Monitorowane Maszyny</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-server"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= $totalAssets ?></div>
                <div class="stat-card__desc text-muted">Aktywne zlecenia: <?= $activeCount ?></div>
            </div>
        </section>

        <section class="data-table-container">
            <div class="table-responsive">
                <table class="data-table" aria-label="Historia rekomendacji Smart Diagnosis AI">
                    <thead>
                        <tr>
                            <th scope="col">Zlecenie</th>
                            <th scope="col">Maszyna</th>
                            <th scope="col">Rekomendacja AI (Ollama)</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aiDiagnosedTickets as $item): ?>
                            <tr>
                                <td><a href="/tickets/<?= $item->id ?>" class="ticket-code">#WO-<?= $item->id ?></a></td>
                                <td>
                                    <div class="font-semibold"><?= htmlspecialchars($item->assetName) ?></div>
                                    <div class="text-xs font-mono text-muted"><?= htmlspecialchars($item->assetSerialNumber) ?></div>
                                </td>
                                <td class="text-sm"><?= htmlspecialchars($item->aiSuggestion ?? '') ?></td>
                                <td><span class="<?= $item->status->badgeClass() ?>"><?= htmlspecialchars($item->status->label()) ?></span></td>
                                <td class="text-right">
                                    <a href="/tickets/<?= $item->id ?>" class="btn-secondary btn-sm">Szczegóły</a>
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
