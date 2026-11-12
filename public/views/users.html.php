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
        
        <!-- Nagłówek modułu zarządzania personelem -->
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-users-gear text-blue" aria-hidden="true"></i>
                    Zarządzanie Zespołem i Uprawnieniami
                </h1>
                <p class="greeting-subtitle">
                    Ewidencja pracowników serwisu, uprawnienia państwowe (SEP, UDT), role w systemie i statusy dyspozycyjne
                </p>
            </div>
            <div class="flex-row">
                <button type="button" class="btn-secondary" onclick="alert('Eksport listy pracowników do pliku CSV...')">
                    <i class="fa-solid fa-file-csv" aria-hidden="true"></i> Eksportuj CSV
                </button>
                <button type="button" class="btn-primary" onclick="alert('Formularz dodawania nowego pracownika zostanie otwarty.')">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i> Dodaj pracownika
                </button>
            </div>
        </header>

        <!-- Kafelki KPI zespołu -->
        <section class="stats-grid mb-lg" aria-label="Wskaźniki zespołu">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Łącznie pracowników</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-users"></i></span>
                </div>
                <div class="stat-card__value"><?= htmlspecialchars((string) $totalUsers) ?></div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-building-user"></i> Zespół serwisowy Baza Poznań</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Dostępni w terenie</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-truck-fast"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= htmlspecialchars((string) $activeTechnicians) ?></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Gotowi do natychmiastowego wyjazdu</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Na interwencji</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-wrench"></i></span>
                </div>
                <div class="stat-card__value text-amber"><?= htmlspecialchars((string) $onDutyTechnicians) ?></div>
                <div class="stat-card__desc text-amber"><i class="fa-solid fa-clock text-xs"></i> W trakcie usuwania awarii</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Średni czas reakcji SLA</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-stopwatch"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $avgSlaResponseMinutes) ?> m</div>
                <div class="stat-card__desc text-blue"><i class="fa-solid fa-chart-line text-xs"></i> Cel SLA &lt; 60 min spełniony</div>
            </div>
        </section>

        <!-- Rejestr pracowników i uprawnień -->
        <section class="data-table-container">
            <div class="table-toolbar">
                <div class="table-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" placeholder="Szukaj pracownika po nazwisku, ID, roli, uprawnieniach..." aria-label="Szukaj pracownika">
                </div>
                <div class="table-filters" role="group" aria-label="Filtry ról">
                    <button class="filter-btn active" type="button">Wszyscy</button>
                    <button class="filter-btn" type="button">Administratorzy</button>
                    <button class="filter-btn" type="button">Technicy (TECHNICIAN)</button>
                    <button class="filter-btn" type="button">Dyżurni 24/7</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Rejestr pracowników">
                    <thead>
                        <tr>
                            <th scope="col">Pracownik</th>
                            <th scope="col">Rola w systemie</th>
                            <th scope="col">Uprawnienia państwowe</th>
                            <th scope="col">Rejon operacyjny</th>
                            <th scope="col">Status dostępności</th>
                            <th scope="col">Aktywne zlecenia</th>
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
                                        <div class="font-bold">Piotr Kowalski</div>
                                        <div class="text-xs text-muted font-mono">ID: TECH-042 • piotr.kowalski@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-blue font-bold">TECHNICIAN (Lead)</span>
                            </td>
                            <td>
                                <div class="flex-row flex-wrap" style="gap: 4px;">
                                    <span class="meta-pill text-xs">SEP E1+D1 &lt;1kV</span>
                                    <span class="meta-pill text-xs">UDT UTB</span>
                                    <span class="meta-pill text-xs">IRATA L1</span>
                                </div>
                            </td>
                            <td>Poznań &amp; Margonin</td>
                            <td>
                                <span class="badge-amber"><i class="fa-solid fa-clock"></i> NA ZLECENIU</span>
                            </td>
                            <td>
                                <span class="font-bold text-blue">2 zlecenia</span>
                            </td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm" title="Zobacz profil i uprawnienia">
                                    <i class="fa-solid fa-id-card"></i> Karta
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold">Katarzyna Adamska</div>
                                        <div class="text-xs text-muted font-mono">ID: ADM-001 • katarzyna.adamska@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-red font-bold">ADMIN (Menedżer)</span>
                            </td>
                            <td>
                                <div class="flex-row flex-wrap" style="gap: 4px;">
                                    <span class="meta-pill text-xs">Koordynator EAM</span>
                                    <span class="meta-pill text-xs">BHP Inspektor</span>
                                </div>
                            </td>
                            <td>Centrala Poznań</td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check"></i> W BIURZE</span>
                            </td>
                            <td>
                                <span class="text-muted">—</span>
                            </td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm">
                                    <i class="fa-solid fa-id-card"></i> Karta
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-wrench"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold">Marek Nowak</div>
                                        <div class="text-xs text-muted font-mono">ID: TECH-088 • marek.nowak@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-blue font-bold">TECHNICIAN</span>
                            </td>
                            <td>
                                <div class="flex-row flex-wrap" style="gap: 4px;">
                                    <span class="meta-pill text-xs">SEP E1</span>
                                    <span class="meta-pill text-xs">F-Gazy</span>
                                    <span class="meta-pill text-xs">Pneumatyka</span>
                                </div>
                            </td>
                            <td>Bolechowo &amp; Swarzędz</td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check"></i> DOSTĘPNY</span>
                            </td>
                            <td>
                                <span class="font-bold text-green">1 zlecenie</span>
                            </td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm">
                                    <i class="fa-solid fa-id-card"></i> Karta
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-row">
                                    <div class="avatar-circle">
                                        <i class="fa-solid fa-laptop-code"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold">Tomasz Wiśniewski</div>
                                        <div class="text-xs text-muted font-mono">ID: TECH-103 • tomasz.wisniewski@assetfix.ai</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-blue font-bold">TECHNICIAN (IoT/AI)</span>
                            </td>
                            <td>
                                <div class="flex-row flex-wrap" style="gap: 4px;">
                                    <span class="meta-pill text-xs">SEP E1+D1</span>
                                    <span class="meta-pill text-xs">Automatyka PLC</span>
                                    <span class="meta-pill text-xs">Ollama AI</span>
                                </div>
                            </td>
                            <td>Cała Wielkopolska</td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check"></i> DOSTĘPNY</span>
                            </td>
                            <td>
                                <span class="text-muted">0 zleceń</span>
                            </td>
                            <td class="text-right">
                                <a href="/profile" class="btn-secondary btn-sm">
                                    <i class="fa-solid fa-id-card"></i> Karta
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>
