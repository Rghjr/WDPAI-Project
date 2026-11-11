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
                <h1>Cześć, Piotr! 👋</h1>
                <p class="greeting-subtitle">
                    <i class="fa-solid fa-wrench" aria-hidden="true"></i>
                    Główny Technik Serwisu • Zmiana Poranna
                </p>
            </div>
            <div class="greeting-meta">
                <span class="meta-pill green">
                    <span class="status-dot"></span> Dostępny w terenie
                </span>
                <span class="meta-pill">
                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i> Baza Poznań sync: 2m temu
                </span>
                <a href="/tickets/add" class="btn-primary">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Nowe zgłoszenie
                </a>
            </div>
        </header>

        <!-- Statystyki KPI -->
        <section class="stats-grid" aria-label="Wskaźniki operacyjne">
            <article class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Dzisiejsze zlecenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value">5</div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i> 3 zaplanowane • 1 w toku
                </div>
            </article>

            <article class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Pilne / Awaria SLA</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value">1 <span class="text-sm font-semibold">KRYTYCZNE</span></div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-stopwatch" aria-hidden="true"></i> Wymagany czas reakcji: &lt; 2h
                </div>
            </article>

            <article class="stat-card success">
                <div class="stat-card__top">
                    <span class="stat-card__title">Sprawność Floty (SLA)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value">98.4%</div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i> +1.2% względem ubiegłego tyg.
                </div>
            </article>

            <article class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Park Maszynowy</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-server" aria-hidden="true"></i></span>
                </div>
                <div class="stat-card__value">12</div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-circle text-green text-xs"></i> 10 online • 2 w przeglądzie
                </div>
            </article>
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
                        <i class="fa-solid fa-list-check" aria-hidden="true"></i> Przydzielone zlecenia na dziś
                    </h2>
                    <span class="badge-blue">3 aktywne</span>
                </div>

                <div class="tasks-list">
                    <!-- Zlecenie 1 (Krytyczne) -->
                    <article class="task-card border-red">
                        <div class="task-header">
                            <span class="task-id">#WO-2024-8841</span>
                            <span class="badge-red"><i class="fa-solid fa-circle text-xs"></i> KRYTYCZNY (SLA 2H)</span>
                        </div>
                        <h3 class="task-title">Awaria sprężarki śrubowej Atlas Copco GA 75 VSD+</h3>
                        <p class="task-location">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                            Zakład Produkcyjny Solaris Bus &amp; Coach, Bolechowo
                        </p>
                        <div class="task-tags">
                            <span class="tag red-light"><i class="fa-solid fa-wave-square" aria-hidden="true"></i> Wysoka wibracja łożyska</span>
                            <span class="tag gray-light"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> 4.2 km stąd</span>
                            <span class="tag blue-light"><i class="fa-solid fa-robot" aria-hidden="true"></i> AI Diagnoza gotowa</span>
                        </div>
                        <div class="task-footer">
                            <span class="task-time">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i> 08:30 - 10:30
                            </span>
                            <div class="flex-row gap-sm">
                                <a href="/tickets/1" class="btn-primary">
                                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Otwórz zlecenie
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Zlecenie 2 (W toku) -->
                    <article class="task-card border-amber">
                        <div class="task-header">
                            <span class="task-id">#WO-2024-8839</span>
                            <span class="badge-amber"><i class="fa-solid fa-spinner fa-spin text-xs"></i> W TRAKCIE NAPRAWY</span>
                        </div>
                        <h3 class="task-title">Winda Osobowa KONE B3 – Błąd czujnika drzwi</h3>
                        <p class="task-location">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                            Biurowiec Pixel, ul. Grunwaldzka, Poznań
                        </p>
                        <div class="task-tags">
                            <span class="tag amber-light"><i class="fa-solid fa-door-closed" aria-hidden="true"></i> Blokada piętra 4</span>
                            <span class="tag gray-light"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> 8.7 km stąd</span>
                        </div>
                        <div class="task-footer">
                            <span class="task-time">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i> 11:00 - 13:00
                            </span>
                            <a href="/tickets/2" class="btn-secondary">
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Szczegóły
                            </a>
                        </div>
                    </article>

                    <!-- Zlecenie 3 (Zaplanowane) -->
                    <article class="task-card border-green">
                        <div class="task-header">
                            <span class="task-id">#WO-2024-8835</span>
                            <span class="badge-green"><i class="fa-solid fa-calendar-check text-xs"></i> ZAPLANOWANY PRZEGLĄD</span>
                        </div>
                        <h3 class="task-title">Agregat Chłodniczy Carrier 30XA – Kontrola szczelności</h3>
                        <p class="task-location">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                            Centrum Logistyczne Komorniki
                        </p>
                        <div class="task-tags">
                            <span class="tag green-light"><i class="fa-solid fa-snowflake" aria-hidden="true"></i> Okresowa inspekcja</span>
                            <span class="tag gray-light"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> 14.1 km stąd</span>
                        </div>
                        <div class="task-footer">
                            <span class="task-time">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i> 14:00 - 16:30
                            </span>
                            <a href="/tickets/3" class="btn-secondary">
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Szczegóły
                            </a>
                        </div>
                    </article>
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

                <div class="ai-telemetry-box">
                    <div class="text-xs font-bold text-muted mb-sm">
                        Telemetria na żywo: Turbina V90 #04
                    </div>
                    <div class="telemetry-row">
                        <span class="telemetry-label">Drgania osiowe FFT:</span>
                        <span class="telemetry-value text-red">8.4 mm/s (kryt.)</span>
                    </div>
                    <div class="telemetry-row">
                        <span class="telemetry-label">Temperatura oleju:</span>
                        <span class="telemetry-value text-amber">78.2 °C (podwyższona)</span>
                    </div>
                    <div class="telemetry-row">
                        <span class="telemetry-label">Ciśnienie w układzie:</span>
                        <span class="telemetry-value text-green">3.4 bar (w normie)</span>
                    </div>
                </div>

                <div class="ai-suggestion-box">
                    <strong><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Sugerowana akcja serwisowa:</strong>
                    Wykryto mikropęknięcia bieżni wewnętrznej łożyska oporowego wału głównego. Zaleca się natychmiastowe wstrzymanie cyklu roboczego oraz inspekcję zespołu łożyskowego przed wystąpieniem zatarcia.
                </div>

                <a href="/tickets/1" class="btn-ai btn-full">
                    <i class="fa-solid fa-microchip" aria-hidden="true"></i> Zobacz pełną analizę AI
                </a>
            </aside>

        </div>

    </main>
</body>
</html>
