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
        
        <!-- Nagłówek modułu maszyn -->
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-industry text-blue" aria-hidden="true"></i>
                    Park Maszynowy i Rejestr Zasobów (EAM)
                </h1>
                <p class="greeting-subtitle">
                    Ewidencja maszyn, telemetria IoT, historia przeglądów i stan techniczny
                </p>
            </div>
            <div class="flex-row">
                <span class="meta-pill">
                    Łącznie maszyn w bazie: <strong class="text-blue"><?= htmlspecialchars((string) $totalAssets) ?></strong>
                </span>
                <a href="/tickets/add" class="btn-primary">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Zgłoś awarię maszyny
                </a>
            </div>
        </header>

        <!-- Kafelki szybkiego statusu floty -->
        <section class="stats-grid mb-lg" aria-label="Status floty">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywne urządzenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-check-double"></i></span>
                </div>
                <div class="stat-card__value">10</div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Stan operacyjny OK</div>
            </div>

            <div class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Awarie w toku</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                </div>
                <div class="stat-card__value">1</div>
                <div class="stat-card__desc"><i class="fa-solid fa-fire"></i> Przestój produkcyjny</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy w 30 dni</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-days"></i></span>
                </div>
                <div class="stat-card__value">2</div>
                <div class="stat-card__desc"><i class="fa-solid fa-bell"></i> Wymagany audyt CRON</div>
            </div>
        </section>

        <!-- Tabela rejestru maszyn -->
        <div class="data-table-container">
            <div class="table-toolbar">
                <div class="table-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" placeholder="Szukaj po nazwie, numerze seryjnym, kategorii..." aria-label="Szukaj maszyny">
                </div>
                <div class="table-filters" role="group" aria-label="Filtry kategorii">
                    <button class="filter-btn active" type="button">Wszystkie</button>
                    <button class="filter-btn" type="button">OZE / Wiatr</button>
                    <button class="filter-btn" type="button">Dźwigi</button>
                    <button class="filter-btn" type="button">HVAC &amp; Chłodnictwo</button>
                    <button class="filter-btn" type="button">Sprężarki</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Ewidencja maszyn">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nazwa Urządzenia</th>
                            <th scope="col">Numer Seryjny</th>
                            <th scope="col">Kategoria</th>
                            <th scope="col">Status Techniczny</th>
                            <th scope="col">Ostatni Przegląd</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-mono">#1</td>
                            <td>
                                <div class="font-bold">Turbina Wiatrowa V90 #04</div>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Farma Wiatrowa Margonin</div>
                            </td>
                            <td>
                                <span class="badge-serial">TURB-2024-9004</span>
                            </td>
                            <td>OZE / Wiatr</td>
                            <td>
                                <span class="badge-red"><i class="fa-solid fa-triangle-exclamation"></i> AWARIA</span>
                            </td>
                            <td>2026-01-15</td>
                            <td class="text-right">
                                <a href="/tickets/1" class="btn-primary btn-sm">
                                    <i class="fa-solid fa-wrench"></i> Serwis
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-mono">#2</td>
                            <td>
                                <div class="font-bold">Winda Osobowa KONE B3</div>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Biurowiec Pixel, Poznań</div>
                            </td>
                            <td>
                                <span class="badge-serial">ELEV-8832-K3</span>
                            </td>
                            <td>Dźwigi osobowe</td>
                            <td>
                                <span class="badge-amber"><i class="fa-solid fa-clock"></i> W NAPRAWIE</span>
                            </td>
                            <td>2026-05-10</td>
                            <td class="text-right">
                                <a href="/tickets/2" class="btn-secondary btn-sm">
                                    Szczegóły
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-mono">#3</td>
                            <td>
                                <div class="font-bold">Sprężarka śrubowa Atlas Copco GA 75</div>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Zakład Solaris, Bolechowo</div>
                            </td>
                            <td>
                                <span class="badge-serial">COMP-AC-7599</span>
                            </td>
                            <td>Sprężarki przemysłowe</td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check"></i> SPRAWNA</span>
                            </td>
                            <td>2026-09-01</td>
                            <td class="text-right">
                                <a href="/tickets/add" class="btn-secondary btn-sm">
                                    Zgłoś
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-mono">#4</td>
                            <td>
                                <div class="font-bold">Agregat Chłodniczy Carrier 30XA</div>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Magazyn Komorniki</div>
                            </td>
                            <td>
                                <span class="badge-serial">HVAC-CAR-011</span>
                            </td>
                            <td>HVAC &amp; Chłodnictwo</td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check"></i> SPRAWNA</span>
                            </td>
                            <td>2026-04-18</td>
                            <td class="text-right">
                                <a href="/tickets/3" class="btn-secondary btn-sm">
                                    Szczegóły
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>
