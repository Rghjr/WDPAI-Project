<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulpit Operacyjny | AssetFix AI</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1c520e4603.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>

    <main class="app-container">
        
        <!-- Powitanie i status operacyjny -->
        <header class="dashboard-header">
            <div class="greeting-info">
                <h1>Cześć, <?= htmlspecialchars($currentUser?->firstName ?? 'Serwisant') ?>! 👋</h1>
                <p class="greeting-subtitle">
                    <i class="fa-solid fa-wrench" aria-hidden="true"></i>
                    <?= htmlspecialchars($currentUser?->employeeCode ?? 'TECH') ?> • <?= htmlspecialchars($currentUser?->baseLocation ?? 'Centrala') ?>
                </p>
            </div>
            <div class="greeting-meta">
                <span class="meta-pill green">
                    <span class="status-dot"></span> Dostępny w terenie
                </span>
                <span class="meta-pill">
                    <i class="fa-solid fa-database" aria-hidden="true"></i> PostgreSQL połączono
                </span>
                <a href="/tickets/add" class="btn-primary">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Nowe zgłoszenie
                </a>
            </div>
        </header>

        <?php
        $totalAssets = max(1, (int) ($assetStats['total'] ?? 0));
        $operationalAssets = (int) ($assetStats['operational_count'] ?? 0);
        $fleetHealth = number_format(($operationalAssets / $totalAssets) * 100, 1);
        $inServiceAssets = (int) ($assetStats['in_repair_count'] ?? 0) + (int) ($assetStats['out_of_service_count'] ?? 0);
        ?>

        <!-- Statystyki KPI -->
        <section class="stats-grid" aria-label="Wskaźniki operacyjne">
            <a href="/tickets?filter=today" class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywne zlecenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value"><?= (int) ($ticketStats['active_count'] ?? 0) ?></div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i> <?= (int) ($ticketStats['open_count'] ?? 0) ?> otwartych • <?= (int) ($ticketStats['in_progress_count'] ?? 0) ?> w toku
                </div>
            </a>

            <a href="/tickets?filter=urgent" class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Pilne / Awaria SLA</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value"><?= (int) ($ticketStats['critical_count'] ?? 0) ?> <span class="text-sm font-semibold">KRYTYCZNE</span></div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-stopwatch" aria-hidden="true"></i> Łącznie pilnych (HIGH/CRIT): <?= (int) ($ticketStats['urgent_count'] ?? 0) ?>
                </div>
            </a>

            <a href="/assets" class="stat-card success">
                <div class="stat-card__top">
                    <span class="stat-card__title">Sprawność Floty (SLA)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value"><?= htmlspecialchars($fleetHealth) ?>%</div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i> <?= $operationalAssets ?> z <?= (int) ($assetStats['total'] ?? 0) ?> maszyn operacyjnych
                </div>
            </a>

            <a href="/assets" class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Park Maszynowy</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-server" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value"><?= (int) ($assetStats['total'] ?? 0) ?></div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-circle text-green text-xs"></i> <?= $operationalAssets ?> online • <?= $inServiceAssets ?> w serwisie
                </div>
            </a>
        </section>

        <!-- Szybkie operacje -->
        <section class="quick-actions-section" aria-label="Szybkie operacje">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i> Szybkie operacje serwisowe
                </h2>
                <span class="section-subtitle">Gotowość do akcji mobilnej</span>
            </div>
            <div class="actions-grid">
                <button class="action-btn blue" type="button">
                    <i class="fa-solid fa-qrcode" aria-hidden="true"></i>
                    <div>
                        <strong>Skanuj kod QR</strong>
                        <div class="text-xs text-muted">Identyfikacja maszyny</div>
                    </div>
                </button>
                <a href="/tickets/add" class="action-btn red">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                    <div>
                        <strong>Zgłoś nagłą awarię</strong>
                        <div class="text-xs text-muted">Priorytet krytyczny</div>
                    </div>
                </a>
                <button class="action-btn dark" type="button">
                    <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                    <div>
                        <strong>Mapa obiektów</strong>
                        <div class="text-xs text-muted">Trasy dojazdu</div>
                    </div>
                </button>
                <button class="action-btn purple" type="button">
                    <i class="fa-solid fa-brain" aria-hidden="true"></i>
                    <div>
                        <strong>Smart Diagnosis AI</strong>
                        <div class="text-xs text-muted">Silnik Ollama</div>
                    </div>
                </button>
            </div>
        </section>

        <!-- Główny układ: Zlecenia na dziś + Panel Smart Diagnosis AI -->
        <div class="dashboard-main-grid">
            
            <!-- Lista Zleceń na dziś -->
            <section class="tasks" aria-labelledby="today-tasks-title">
                <div class="section-header">
                    <h2 id="today-tasks-title" class="section-title">
                        <i class="fa-solid fa-list-check" aria-hidden="true"></i> Najpilniejsze aktywne zlecenia
                    </h2>
                    <span class="badge-blue"><?= (int) ($ticketStats['active_count'] ?? 0) ?> aktywnych</span>
                </div>

                <div class="tasks-list">
                    <?php if (empty($activeTickets)): ?>
                        <p class="text-muted">Brak aktywnych zleceń w bazie danych.</p>
                    <?php else: ?>
                        <?php foreach ($activeTickets as $item): ?>
                            <article class="task-card <?= $item->priority->borderClass() ?>">
                                <div class="task-header">
                                    <span class="task-id">#WO-<?= $item->id ?></span>
                                    <span class="<?= $item->priority->badgeClass() ?>"><i class="fa-solid fa-circle text-xs"></i> <?= htmlspecialchars($item->priority->label()) ?></span>
                                </div>
                                <h3 class="task-title"><?= htmlspecialchars($item->title) ?></h3>
                                <p class="task-location">
                                    <i class="fa-solid fa-building" aria-hidden="true"></i>
                                    <?= htmlspecialchars($item->assetName) ?> — <?= htmlspecialchars($item->clientName) ?>, <?= htmlspecialchars($item->clientCity) ?>
                                </p>
                                <div class="task-tags">
                                    <span class="tag gray-light"><i class="fa-solid fa-barcode" aria-hidden="true"></i> <?= htmlspecialchars($item->assetSerialNumber) ?></span>
                                    <?php if ($item->aiSuggestion !== null && $item->aiSuggestion !== ''): ?>
                                        <span class="tag blue-light"><i class="fa-solid fa-robot" aria-hidden="true"></i> AI Diagnoza gotowa</span>
                                    <?php endif; ?>
                                </div>
                                <div class="task-footer">
                                    <span class="task-time">
                                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                        <?= htmlspecialchars(substr($item->createdAt, 0, 16)) ?>
                                    </span>
                                    <div class="flex-row gap-sm">
                                        <a href="/tickets/<?= $item->id ?>" class="btn-primary">
                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Otwórz zlecenie
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Panel boczny: Smart Diagnosis AI & Telemetria -->
            <aside class="ai-diagnosis-widget" aria-label="Rekomendacje modułu AI">
                <div class="ai-widget-header">
                    <div class="ai-widget-brand">
                        <span class="ai-widget-icon"><i class="fa-solid fa-brain" aria-hidden="true"></i></span>
                        <div>
                            <div class="ai-widget-title">Smart Diagnosis AI</div>
                            <div class="ai-widget-subtitle">Silnik predykcyjny Ollama LLM</div>
                        </div>
                    </div>
                    <span class="ai-badge">Aktywny</span>
                </div>

                <?php if ($criticalIncident !== null): ?>
                    <div class="ai-telemetry-box">
                        <div class="text-xs font-bold text-muted mb-sm">
                            Incydent priorytetowy: <?= htmlspecialchars($criticalIncident->assetName) ?>
                        </div>
                        <div class="telemetry-row">
                            <span class="telemetry-label">Numer seryjny:</span>
                            <span class="telemetry-value font-mono"><?= htmlspecialchars($criticalIncident->assetSerialNumber) ?></span>
                        </div>
                        <div class="telemetry-row">
                            <span class="telemetry-label">Klient / Lokalizacja:</span>
                            <span class="telemetry-value"><?= htmlspecialchars($criticalIncident->clientCity) ?></span>
                        </div>
                        <div class="telemetry-row">
                            <span class="telemetry-label">Status zgłoszenia:</span>
                            <span class="telemetry-value text-red"><?= htmlspecialchars($criticalIncident->status->label()) ?></span>
                        </div>
                    </div>

                    <div class="ai-suggestion-box">
                        <strong><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Sugerowana akcja serwisowa:</strong>
                        <?= htmlspecialchars($criticalIncident->aiSuggestion ?? $criticalIncident->description) ?>
                    </div>

                    <a href="/tickets/<?= $criticalIncident->id ?>" class="btn-ai btn-full">
                        <i class="fa-solid fa-microchip" aria-hidden="true"></i> Zobacz pełną analizę AI
                    </a>
                <?php else: ?>
                    <div class="ai-suggestion-box">
                        Brak krytycznych incydentów wymagających interwencji AI.
                    </div>
                <?php endif; ?>
            </aside>

        </div>

    </main>
</body>
</html>
