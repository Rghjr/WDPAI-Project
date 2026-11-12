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
        
        <!-- Nagłówek modułu harmonogramu przeglądów -->
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-calendar-check text-blue" aria-hidden="true"></i>
                    Harmonogram Przeglądów i Dozoru Technicznego (EAM)
                </h1>
                <p class="greeting-subtitle">
                    Prewencyjne utrzymanie ruchu (PM), badania okresowe Urzędu Dozoru Technicznego (UDT) i automatyzacja alertów CRON
                </p>
            </div>
            <div class="flex-row">
                <button type="button" class="btn-secondary" onclick="alert('Generowanie zbiorczego raportu gotowości UDT...')">
                    <i class="fa-solid fa-file-pdf" aria-hidden="true"></i> Raport UDT (PDF)
                </button>
                <a href="/assets/add" class="btn-primary">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Zaplanuj nowy przegląd
                </a>
            </div>
        </header>

        <!-- Kafelki KPI przeglądów -->
        <section class="stats-grid mb-lg" aria-label="Wskaźniki przeglądów">
            <div class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy &lt; 7 dni (CRON Alert)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                </div>
                <div class="stat-card__value"><?= htmlspecialchars((string) $dueInSevenDays) ?></div>
                <div class="stat-card__desc"><i class="fa-solid fa-bell"></i> Wysłano powiadomienia e-mail (Mailpit)</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">W tym miesiącu</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-days"></i></span>
                </div>
                <div class="stat-card__value text-amber"><?= htmlspecialchars((string) $dueThisMonth) ?></div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-clock"></i> Zaplanowane badania UDT i serwisy</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Zrealizowane w kwartale</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-circle-check"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= htmlspecialchars((string) $completedThisQuarter) ?></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-check-double"></i> Protokoły podpisane i zarchiwizowane</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Zgodność z przepisami UDT</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-shield-halved"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $udtComplianceRate) ?> %</div>
                <div class="stat-card__desc text-blue"><i class="fa-solid fa-arrow-trend-up"></i> Wskaźnik bezpieczeństwa parku maszyn</div>
            </div>
        </section>

        <!-- Informacja o module CRON -->
        <section class="card-block mb-lg" style="border-left: 4px solid var(--clr-blue); background: var(--clr-blue-subtle);">
            <div class="flex-between">
                <div class="flex-row">
                    <i class="fa-solid fa-robot text-blue text-xl"></i>
                    <div>
                        <h2 class="text-sm font-bold text-blue">Automatyzacja CRON: Monitorowanie Terminów Przeglądów</h2>
                        <p class="text-xs text-muted mt-xs">
                            Zadanie harmonogramu systemowego uruchamia się codziennie o godzinie 06:00. Wykrywa urządzenia z terminem inspekcji przypadającym w ciągu 7 dni, wysyła powiadomienia e-mail (poprzez moduł PHPMailer / Mailpit) i rejestruje wpis w tabeli audytowej <code>reminder_logs</code>.
                        </p>
                    </div>
                </div>
                <span class="meta-pill text-xs">
                    <i class="fa-solid fa-check text-green"></i> Ostatni skrypt CRON: dzisiaj 06:00 (Status: OK)
                </span>
            </div>
        </section>

        <!-- Tabela harmonogramu przeglądów -->
        <section class="data-table-container">
            <div class="table-toolbar">
                <div class="table-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" placeholder="Szukaj po urządzeniu, numerze UDT, serwisancie..." aria-label="Szukaj przeglądu">
                </div>
                <div class="table-filters" role="group" aria-label="Filtry inspekcji">
                    <button class="filter-btn active" type="button">Wszystkie</button>
                    <button class="filter-btn" type="button">Pilne (&lt; 7 dni)</button>
                    <button class="filter-btn" type="button">Dozór UDT</button>
                    <button class="filter-btn" type="button">Gwarancyjne</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" aria-label="Harmonogram badań technicznych">
                    <thead>
                        <tr>
                            <th scope="col">Data badania</th>
                            <th scope="col">Urządzenie i lokalizacja</th>
                            <th scope="col">Nr księgi UDT</th>
                            <th scope="col">Zakres inspekcji</th>
                            <th scope="col">Termin</th>
                            <th scope="col">Przypisany technik</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold text-red">2026-11-15</td>
                            <td>
                                <a href="/assets/2" class="font-bold text-blue">Winda Osobowa KONE B3</a>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Biurowiec Pixel, Poznań</div>
                            </td>
                            <td><span class="badge-serial">UDT-POZ-ELEV-9941</span></td>
                            <td>
                                <div class="font-semibold text-sm">Roczna Rewizja Okresowa UDT</div>
                                <div class="text-xs text-muted">Próba chwytaczy, kontrola lin i ogranicznika prędkości</div>
                            </td>
                            <td><span class="badge-red"><i class="fa-solid fa-clock"></i> Za 3 dni</span></td>
                            <td>Piotr Kowalski</td>
                            <td class="text-right">
                                <a href="/assets/2" class="btn-primary btn-sm">
                                    <i class="fa-solid fa-wrench"></i> Realizuj
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-bold text-red">2026-11-20</td>
                            <td>
                                <a href="/assets/1" class="font-bold text-blue">Turbina Wiatrowa V90 #04</a>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Farma Wiatrowa Margonin</div>
                            </td>
                            <td><span class="badge-serial">UDT-POZ-7712/2021</span></td>
                            <td>
                                <div class="font-semibold text-sm">Wymiana oleju przekładni i rewizja łopat</div>
                                <div class="text-xs text-muted">Inspekcja po przekroczeniu 18 000 motogodzin</div>
                            </td>
                            <td><span class="badge-red"><i class="fa-solid fa-clock"></i> Za 8 dni</span></td>
                            <td>Piotr Kowalski</td>
                            <td class="text-right">
                                <a href="/assets/1" class="btn-primary btn-sm">
                                    <i class="fa-solid fa-wrench"></i> Realizuj
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>2026-12-05</td>
                            <td>
                                <a href="/assets/3" class="font-bold text-blue">Sprężarka Śrubowa Atlas Copco GA 75</a>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Solaris Bus &amp; Coach, Bolechowo</div>
                            </td>
                            <td><span class="badge-serial">UDT-POZ-ZB-3129</span></td>
                            <td>
                                <div class="font-semibold text-sm">Przegląd ciśnieniowy zbiornika buforowego</div>
                                <div class="text-xs text-muted">Rewizja wewnętrzna zaworu bezpieczeństwa UDT</div>
                            </td>
                            <td><span class="badge-amber"><i class="fa-solid fa-calendar"></i> Za 23 dni</span></td>
                            <td>Marek Nowak</td>
                            <td class="text-right">
                                <a href="/assets/3" class="btn-secondary btn-sm">
                                    Paszport EAM
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>2027-02-18</td>
                            <td>
                                <a href="/assets/4" class="font-bold text-blue">Agregat Chłodniczy Carrier 30XA</a>
                                <div class="text-muted text-xs"><i class="fa-solid fa-location-dot"></i> Centrum Logistyczne Żabka, Komorniki</div>
                            </td>
                            <td><span class="badge-serial">UDT-POZ-CHL-0911</span></td>
                            <td>
                                <div class="font-semibold text-sm">Kontrola szczelności układu F-Gaz</div>
                                <div class="text-xs text-muted">Wpis do Centralnego Rejestru Operatorów (CRO)</div>
                            </td>
                            <td><span class="badge-green"><i class="fa-solid fa-check"></i> Standardowy</span></td>
                            <td>Marek Nowak</td>
                            <td class="text-right">
                                <a href="/assets/1" class="btn-secondary btn-sm">
                                    Paszport EAM
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
