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
        
        <!-- Nagłówek Zespołu Technicznego i Uprawnień (Wzór Stitch w7) -->
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-users-gear text-blue" aria-hidden="true"></i>
                    Zespół Techniczny i Uprawnienia
                </h1>
                <p class="greeting-subtitle">
                    Ewidencja specjalistów UR, certyfikatów SEP/UDT, przypisanych rejonów oraz bieżącej dyspozycyjności
                </p>
            </div>
            <div class="flex-row flex-wrap gap-sm">
                <button type="button" class="btn-secondary btn-sm" onclick="alert('Generowanie zestawienia kwalifikacji SEP/UDT do formatu PDF...')">
                    <i class="fa-solid fa-file-pdf"></i> Eksport (PDF / CSV)
                </button>
                <button type="button" class="btn-primary btn-sm" onclick="alert('Formularz rejestracji nowego serwisanta zostanie otwarty.')">
                    <i class="fa-solid fa-user-plus"></i> Dodaj pracownika
                </button>
            </div>
        </header>

        <!-- 4 Czyste Metryki KPI Zespołu -->
        <section class="stats-grid mb-lg" aria-label="Wskaźniki zespołu">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywni w terenie</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-truck-fast"></i></span>
                </div>
                <div class="stat-card__value text-blue">10 <span class="text-sm font-normal text-muted">/ 14</span></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> 4 techników w gotowości na bazie</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Ważność Certyfikatów SEP/UDT</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-certificate"></i></span>
                </div>
                <div class="stat-card__value text-green">100%</div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-shield-check"></i> 0 wygasających uprawnień w tym miesiącu</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Średni Czas Reakcji SLA</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-stopwatch"></i></span>
                </div>
                <div class="stat-card__value text-blue">28 min</div>
                <div class="stat-card__desc text-blue"><i class="fa-solid fa-chart-line"></i> Cel SLA &lt; 45 min spełniony</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Otwarte Zlecenia w Toku</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-wrench"></i></span>
                </div>
                <div class="stat-card__value text-amber">8</div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-calendar-check"></i> 1 zlecenie krytyczne P1</div>
            </div>
        </section>

        <!-- Rejestr Pracowników i Uprawnień -->
        <section class="data-table-container">
            <div class="table-toolbar">
                <div class="table-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" placeholder="Szukaj pracownika po nazwisku, ID, roli, uprawnieniach..." aria-label="Szukaj pracownika">
                </div>
                <div class="table-filters" role="group" aria-label="Filtry personelu">
                    <button class="filter-btn active" type="button">Wszyscy (14)</button>
                    <button class="filter-btn" type="button">Liderzy UR</button>
                    <button class="filter-btn" type="button">W terenie</button>
                    <button class="filter-btn" type="button">Dyżurni 24/7</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Tabela pracowników serwisu">
                    <thead>
                        <tr>
                            <th scope="col">Specjalista UR</th>
                            <th scope="col">Rola Systemowa</th>
                            <th scope="col">Uprawnienia Państwowe</th>
                            <th scope="col">Rejon Operacyjny</th>
                            <th scope="col">Status Dyspozycyjny</th>
                            <th scope="col">Zlecenia Aktywne</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-user-gear"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">Piotr Kowalski</div>
                                        <div class="text-xs text-muted font-mono">TECH-042 • piotr.kowalski@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-blue font-bold">TECHNICIAN (Lead)</span></td>
                            <td>
                                <div class="flex-row flex-wrap gap-xs">
                                    <span class="meta-pill text-xs">SEP E1+D1 &lt;1kV</span>
                                    <span class="meta-pill text-xs">UDT UTB</span>
                                    <span class="meta-pill text-xs">IRATA L1</span>
                                </div>
                            </td>
                            <td>Poznań &amp; Margonin</td>
                            <td><span class="badge-amber"><i class="fa-solid fa-truck-fast"></i> W TRASIE (DK11)</span></td>
                            <td><span class="font-bold text-red">#WO-8911 (P1)</span></td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm"><i class="fa-solid fa-id-card"></i> Karta</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">Janusz Kamiński</div>
                                        <div class="text-xs text-muted font-mono">ADM-001 • janusz.kaminski@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-red font-bold">ADMIN (Dyrektor UR)</span></td>
                            <td>
                                <div class="flex-row flex-wrap gap-xs">
                                    <span class="meta-pill text-xs">Koordynator EAM</span>
                                    <span class="meta-pill text-xs">Inspektor UDT</span>
                                </div>
                            </td>
                            <td>Centrala Poznań</td>
                            <td><span class="badge-green"><i class="fa-solid fa-building"></i> NA BAZIE</span></td>
                            <td><span class="text-muted">—</span></td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm"><i class="fa-solid fa-id-card"></i> Karta</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-wrench"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">Marek Nowak</div>
                                        <div class="text-xs text-muted font-mono">TECH-088 • marek.nowak@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-blue font-bold">TECHNICIAN</span></td>
                            <td>
                                <div class="flex-row flex-wrap gap-xs">
                                    <span class="meta-pill text-xs">SEP E1</span>
                                    <span class="meta-pill text-xs">F-Gazy</span>
                                    <span class="meta-pill text-xs">Dźwigi UDT</span>
                                </div>
                            </td>
                            <td>Bolechowo &amp; Swarzędz</td>
                            <td><span class="badge-amber"><i class="fa-solid fa-wrench"></i> NA OBIEKCIE (Pixel)</span></td>
                            <td><span class="font-bold text-blue">#WO-8902</span></td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm"><i class="fa-solid fa-id-card"></i> Karta</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-laptop-code"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">Tomasz Wiśniewski</div>
                                        <div class="text-xs text-muted font-mono">TECH-103 • tomasz.wisniewski@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-blue font-bold">TECHNICIAN (IoT/AI)</span></td>
                            <td>
                                <div class="flex-row flex-wrap gap-xs">
                                    <span class="meta-pill text-xs">SEP E1+D1</span>
                                    <span class="meta-pill text-xs">Automatyka PLC</span>
                                    <span class="meta-pill text-xs">Ollama AI</span>
                                </div>
                            </td>
                            <td>Cała Wielkopolska</td>
                            <td><span class="badge-green"><i class="fa-solid fa-check"></i> DOSTĘPNY NA BAZIE</span></td>
                            <td><span class="font-bold text-green">#WO-8850 (Przydział)</span></td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm"><i class="fa-solid fa-id-card"></i> Karta</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>
