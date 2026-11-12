<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1c520e4603.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>

    <main class="container">
        
        <!-- Pasek Kontrolny i Metryki Dyspozytorskie -->
        <header class="card-block mb-lg">
            <div class="flex-between flex-wrap gap-md">
                <!-- Data i Tydzień Operacyjny -->
                <div class="flex-row gap-sm">
                    <span class="meta-pill">
                        <i class="fa-solid fa-calendar-day text-blue"></i>
                        <strong>Dziś, 18 Października 2026</strong> • CW 42
                    </span>
                    <span class="meta-pill green">
                        <span class="status-dot"></span> GPS RTK Fix: Aktywny
                    </span>
                </div>

                <!-- Szybkie Wskaźniki Floty -->
                <div class="flex-row flex-wrap gap-md">
                    <div class="meta-pill">
                        <span class="status-dot"></span>
                        <span><strong><?= htmlspecialchars((string) $activeTechsCount) ?> Techników aktywnych</strong> (<?= htmlspecialchars((string) $techsInTransit) ?> w trasie / <?= htmlspecialchars((string) $techsOnSite) ?> na obiekcie)</span>
                    </div>

                    <div class="meta-pill" style="border-color: rgba(220, 38, 38, 0.4); background: var(--clr-bg-red); color: var(--clr-red);">
                        <i class="fa-solid fa-triangle-exclamation text-red animate-pulse"></i>
                        <span><strong><?= htmlspecialchars((string) $unassignedOrdersCount) ?> Nieprzypisane</strong> (#WO-8850)</span>
                    </div>

                    <div class="meta-pill">
                        <i class="fa-solid fa-stopwatch text-blue"></i>
                        <span>Średni czas SLA: <strong class="text-blue"><?= htmlspecialchars((string) $avgSlaResponseMinutes) ?> min</strong></span>
                    </div>
                </div>

                <!-- Akcje Dyspozytora -->
                <div class="flex-row">
                    <a href="/tickets/add" class="btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Nowe zlecenie #WO
                    </a>
                </div>
            </div>
        </header>

        <!-- Główny Układ Podziału: Mapa GIS (70%) + Panel Dyspozycji (30%) -->
        <div class="map-layout-grid">
            
            <!-- Lewa Kolumna: Interaktywna Mapa Operacyjna GIS -->
            <section class="map-viewport-panel">
                <div class="tactical-map-container">
                    
                    <!-- Pasek telemetryczny radaru GIS -->
                    <div class="map-overlay-header">
                        <div class="radar-status-badge">
                            <i class="fa-solid fa-radar text-blue"></i>
                            <div>
                                <div class="font-bold text-xs">AKTYWNY RADAR FLOTY • AGLOMERACJA POZNAŃ</div>
                                <div class="text-xs text-muted font-mono">Siatka UTM 33N • Odświeżanie: co 4s</div>
                            </div>
                        </div>

                        <div class="map-tools-cluster">
                            <button type="button" class="btn-secondary btn-sm" title="Pokaż strefy przemysłu i logistyki" onclick="alert('Warstwa stref przemysłowych włączona.')">
                                <i class="fa-solid fa-city"></i> Strefy
                            </button>
                            <button type="button" class="btn-secondary btn-sm" title="Wyznacz izochrony dojazdu 15-min" onclick="alert('Wyznaczono 15-minutowe izochrony dojazdu ze stacji Poznań Centralny.')">
                                <i class="fa-solid fa-route"></i> Izochrony
                            </button>
                            <button type="button" class="btn-secondary btn-sm" title="Centruj na bazie Poznań" onclick="alert('Wycentrowano na Baza Poznań Centralny.')">
                                <i class="fa-solid fa-crosshairs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Wektorowe Podłoże Taktyczne GIS z Trasami i Geofencingiem -->
                    <div class="map-canvas-mock">
                        
                        <!-- Wektorowe trasy SVG -->
                        <svg class="map-vector-overlay" viewBox="0 0 1000 600" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="gradUrgent" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#2563eb" stop-opacity="0.9" />
                                    <stop offset="100%" stop-color="#dc2626" stop-opacity="0.9" />
                                </linearGradient>
                                <linearGradient id="gradNormal" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#059669" stop-opacity="0.8" />
                                    <stop offset="100%" stop-color="#2563eb" stop-opacity="0.8" />
                                </linearGradient>
                            </defs>

                            <!-- Strefy przemysłowe (Geofence Polygons) -->
                            <polygon points="120,50 360,40 330,170 140,150" class="geofence-zone oze" />
                            <polygon points="680,240 920,220 940,430 700,450" class="geofence-zone ind" />

                            <!-- Trasa alarmowa Furgon #04 -> Bolechowo Solaris -->
                            <path d="M 480 300 Q 540 210, 600 120" class="route-line urgent" />
                            
                            <!-- Trasa Furgon #02 -> Biurowiec Pixel -->
                            <path d="M 480 300 C 440 320, 390 350, 360 380" class="route-line normal" />

                            <!-- Trasa DK11 na Północ Margonin -->
                            <path d="M 480 300 L 260 90" class="route-line sub" />
                        </svg>

                        <!-- PUNKTY NA MAPIE: AWARIE, MASZYNY I FURGONY GPS -->

                        <!-- Pin #1: Bolechowo - Solaris Bus (Alarm P1, Czerwony Puls) -->
                        <div class="map-pin-wrapper" style="top: 20%; left: 60%;" title="Bolechowo – Solaris Bus: Awaria P1 (WO-8850)">
                            <div class="pin-marker critical animate-bounce">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div class="pin-card-preview">
                                <div class="font-bold text-xs text-red">AWARIA P1: Kaeser SK 22</div>
                                <div class="text-xs text-muted">Solaris Bolechowo • Spadek ciśnienia</div>
                                <div class="text-xs font-mono text-red mt-xs"><i class="fa-solid fa-clock"></i> SLA: 48 min</div>
                            </div>
                        </div>

                        <!-- Pin #2: Margonin - Turbiny V90 (W trakcie prac) -->
                        <div class="map-pin-wrapper" style="top: 15%; left: 26%;" title="Margonin – Turbina V90 #04: Zlecenie w toku">
                            <div class="pin-marker in-progress">
                                <i class="fa-solid fa-wind"></i>
                            </div>
                            <div class="pin-card-preview">
                                <div class="font-bold text-xs text-blue">Turbina Wiatrowa V90 #04</div>
                                <div class="text-xs text-muted">Farma Margonin • Zlecenie #1</div>
                                <div class="text-xs font-semibold text-blue mt-xs">Technik: Piotr Kowalski (ETA 15:10)</div>
                            </div>
                        </div>

                        <!-- Pin #3: Poznań - Biurowiec Pixel (Winda KONE B3) -->
                        <div class="map-pin-wrapper" style="top: 63%; left: 36%;" title="Pixel Poznań – Winda KONE B3">
                            <div class="pin-marker maintenance">
                                <i class="fa-solid fa-elevator"></i>
                            </div>
                            <div class="pin-card-preview">
                                <div class="font-bold text-xs">Winda Osobowa KONE B3</div>
                                <div class="text-xs text-muted">Biurowiec Pixel • WO-8902</div>
                                <div class="text-xs font-semibold text-green mt-xs">Technik: Marek Nowak (Na obiekcie)</div>
                            </div>
                        </div>

                        <!-- Pin #4: Baza Główna Serwisu Poznań Centralny -->
                        <div class="map-pin-wrapper" style="top: 50%; left: 48%;" title="Baza Poznań Centralny – Hub Serwisowy">
                            <div class="pin-marker hub">
                                <i class="fa-solid fa-warehouse"></i>
                            </div>
                            <div class="pin-card-preview">
                                <div class="font-bold text-xs text-blue">Baza Poznań Centralny (HUB UR)</div>
                                <div class="text-xs text-muted">Magazyn części OEM • 4 techników w gotowości</div>
                            </div>
                        </div>

                        <!-- Furgon Serwisowy GPS #04 (Piotr Kowalski w trasie) -->
                        <div class="map-van-marker" style="top: 36%; left: 54%;" title="Furgon #04: Piotr Kowalski (Prędkość: 84 km/h)">
                            <div class="van-dot-pulse"></div>
                            <div class="van-badge">
                                <i class="fa-solid fa-truck-fast"></i> Van #04
                            </div>
                        </div>

                        <!-- Furgon Serwisowy GPS #02 (Marek Nowak na obiekcie) -->
                        <div class="map-van-marker" style="top: 66%; left: 38%;" title="Furgon #02: Marek Nowak (Na obiekcie Pixel)">
                            <div class="van-badge static">
                                <i class="fa-solid fa-truck"></i> Van #02
                            </div>
                        </div>

                    </div>

                    <!-- Dolna legenda mapy taktycznej -->
                    <div class="map-legend-bar">
                        <span class="legend-item"><span class="legend-dot red"></span> Awaria P1 (&lt; 2h SLA)</span>
                        <span class="legend-item"><span class="legend-dot amber"></span> W naprawie / Zlecenie</span>
                        <span class="legend-item"><span class="legend-dot blue"></span> Furgon GPS w trasie</span>
                        <span class="legend-item"><span class="legend-dot green"></span> Dozór UDT / Baza</span>
                    </div>

                </div>
            </section>

            <!-- Prawa Kolumna: Aktywna Dyspozycja i Monitor Floty (30%) -->
            <aside class="dispatch-sidebar-panel">
                
                <!-- Karta Pilnych Zleceń do Przypisania -->
                <div class="card-block mb-md">
                    <div class="flex-between mb-sm">
                        <h2 class="text-sm font-bold flex-row">
                            <i class="fa-solid fa-clipboard-check text-blue"></i> Zlecenia do Dyspozycji
                        </h2>
                        <span class="badge-red text-xs">1 pilne</span>
                    </div>

                    <div class="incident-card urgent">
                        <div class="flex-between">
                            <span class="task-id">#WO-8850 • SLA 2H</span>
                            <span class="badge-red text-xs">P1 KRYTYCZNY</span>
                        </div>
                        <h3 class="font-bold text-sm mt-xs">Kaeser SK 22 – Spadek ciśnienia</h3>
                        <p class="text-xs text-muted">Zakład Solaris Bus &amp; Coach, Bolechowo</p>
                        
                        <div class="ai-recommendation-box mt-sm">
                            <div class="flex-row text-xs font-bold text-ai">
                                <i class="fa-solid fa-brain"></i> Rekomendacja AI Dyspozytora:
                            </div>
                            <p class="text-xs text-muted mt-xs">
                                Przypisz <strong>Tomasz Wiśniewski</strong> (Dostępny w bazie, 18 min dojazdu, certyfikat pneumatyki).
                            </p>
                        </div>

                        <div class="flex-between mt-sm">
                            <span class="text-xs font-mono text-red font-bold">Pozostało: 48 min</span>
                            <button type="button" class="btn-primary btn-sm" onclick="alert('Zlecenie #WO-8850 zostało przypisane do technika Tomasz Wiśniewski. Wysłano trasę GPS i alert SMS.')">
                                <i class="fa-solid fa-user-check"></i> Przypisz
                            </button>
                        </div>
                    </div>

                    <!-- Zlecenie w toku -->
                    <div class="incident-card in-transit mt-sm">
                        <div class="flex-between">
                            <span class="task-id">#WO-8911</span>
                            <span class="badge-amber text-xs">W TRASIE</span>
                        </div>
                        <h3 class="font-bold text-sm mt-xs">Turbina V90 #04 – Niski poziom oleju</h3>
                        <p class="text-xs text-muted">Farma Wiatrowa Margonin</p>
                        <div class="flex-between mt-sm text-xs">
                            <span class="font-bold text-blue"><i class="fa-solid fa-user"></i> Piotr Kowalski</span>
                            <span class="font-mono text-muted">ETA: 15:10 (34 km)</span>
                        </div>
                    </div>
                </div>

                <!-- Karta Statusu Furgonów i Techników GPS -->
                <div class="card-block">
                    <div class="flex-between mb-sm">
                        <h2 class="text-sm font-bold flex-row">
                            <i class="fa-solid fa-satellite-dish text-blue"></i> Flota Serwisowa (GPS Live)
                        </h2>
                        <span class="badge-green text-xs">3 aktywne pojazdy</span>
                    </div>

                    <div class="fleet-list">
                        <div class="fleet-item">
                            <div class="avatar-circle">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex-between">
                                    <span class="font-bold text-sm">Piotr Kowalski</span>
                                    <span class="badge-blue text-xs">Trasa DK11</span>
                                </div>
                                <div class="text-xs text-muted">Van #04 (Ford Transit Custom) • 84 km/h</div>
                                <div class="text-xs text-green mt-xs"><i class="fa-solid fa-location-arrow"></i> Kierunek: Margonin (Zlecenie #1)</div>
                            </div>
                        </div>

                        <div class="fleet-item mt-sm">
                            <div class="avatar-circle">
                                <i class="fa-solid fa-wrench"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex-between">
                                    <span class="font-bold text-sm">Marek Nowak</span>
                                    <span class="badge-amber text-xs">Na obiekcie</span>
                                </div>
                                <div class="text-xs text-muted">Van #02 • Poznań Pixel</div>
                                <div class="text-xs text-muted mt-xs"><i class="fa-solid fa-building"></i> Prace konserwacyjne windy KONE</div>
                            </div>
                        </div>

                        <div class="fleet-item mt-sm">
                            <div class="avatar-circle">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex-between">
                                    <span class="font-bold text-sm">Tomasz Wiśniewski</span>
                                    <span class="badge-green text-xs">Dostępny</span>
                                </div>
                                <div class="text-xs text-muted">Van #07 • Baza Poznań Centralny</div>
                                <div class="text-xs text-green mt-xs"><i class="fa-solid fa-warehouse"></i> Gotowy do podjęcia interwencji P1</div>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
