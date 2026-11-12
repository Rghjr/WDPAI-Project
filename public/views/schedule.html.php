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
        
        <!-- Nagłówek Harmonogramu z Przełącznikiem Zakładek i Przyciskiem AI -->
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-calendar-days text-blue" aria-hidden="true"></i>
                    Harmonogram i Dyspozycja Zespołu UR
                </h1>
                <p class="greeting-subtitle">
                    <?= htmlspecialchars($currentWeek) ?> • Baza Poznań Centralny
                </p>
            </div>
            
            <div class="flex-row flex-wrap gap-sm">
                <!-- Przełącznik Zakładek (Eliminacja Duplikacji Ekrany) -->
                <div class="view-tab-pill-group">
                    <a href="/schedule?tab=dispatch" class="view-tab-btn <?= ($activeTab !== 'udt' ? 'active' : '') ?>">
                        <i class="fa-solid fa-users"></i> Dyspozycja Techników (Gantt)
                    </a>
                    <a href="/schedule?tab=udt" class="view-tab-btn <?= ($activeTab === 'udt' ? 'active' : '') ?>">
                        <i class="fa-solid fa-shield-halved"></i> Dozór UDT &amp; CRON (<?= htmlspecialchars((string) $dueUdtInSevenDays) ?> pilne)
                    </a>
                </div>

                <!-- Przycisk Automatycznego Planowania AI -->
                <button type="button" class="btn-ai" onclick="alert('Uruchomiono optymalizator grafiku AI Ollama: Przypisano 3 oczekujące zlecenia do techników z uwzględnieniem certyfikatów SEP/UDT oraz najkrótszych tras dojazdowych.')">
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Automatyczne planowanie AI
                </button>
            </div>
        </header>

        <!-- 4 Czyste Karty Wskaźników KPI -->
        <section class="stats-grid mb-lg" aria-label="Wskaźniki dyspozycji">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Zaplanowane Zlecenia</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-calendar-check"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $assignedTicketsCount) ?> / <?= htmlspecialchars((string) $totalPlannedTickets) ?></div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-check"></i> 90% pokrycia zapotrzebowania</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Obciążenie Zespołu</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-gauge-high"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= htmlspecialchars((string) $teamUtilizationPercent) ?> %</div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Równomierny rozkład godzin</div>
            </div>

            <div class="stat-card <?= ($dueUdtInSevenDays > 0 ? 'critical' : '') ?>">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przeglądy UDT (&lt; 7 dni)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-bell"></i></span>
                </div>
                <div class="stat-card__value text-red"><?= htmlspecialchars((string) $dueUdtInSevenDays) ?></div>
                <div class="stat-card__desc text-red"><i class="fa-solid fa-triangle-exclamation"></i> Alert CRON wysłany do menedżera</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Średni Czas Dojazdu</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-route"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $avgTravelMinutes) ?> min</div>
                <div class="stat-card__desc text-blue"><i class="fa-solid fa-car-side"></i> Rejon aglomeracji poznańskiej</div>
            </div>
        </section>

        <?php if ($activeTab !== 'udt'): ?>
            <!-- ZAKŁADKA 1: TABLICA DYSPOZYTORSKA I HARMONOGRAM GANTTA -->
            <section class="card-block">
                <div class="flex-between mb-md">
                    <div class="flex-row">
                        <span class="meta-pill"><i class="fa-solid fa-calendar-week"></i> Tydzień 42: 14 – 20 Października</span>
                        <span class="meta-pill text-xs">Godziny operacyjne: 08:00 – 18:00</span>
                    </div>

                    <div class="flex-row gap-xs">
                        <a href="/map" class="btn-secondary btn-sm">
                            <i class="fa-solid fa-map-location-dot"></i> Podgląd na Mapie Serwisu
                        </a>
                        <button type="button" class="btn-secondary btn-sm" onclick="window.print()">
                            <i class="fa-solid fa-print"></i> Drukuj grafik
                        </button>
                    </div>
                </div>

                <!-- Tabela Tygodniowa Gantta Techników -->
                <div class="table-responsive">
                    <table class="schedule-gantt-table" aria-label="Harmonogram techników">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 200px;">Technik Serwisowy</th>
                                <th scope="col">Poniedziałek (14.10)</th>
                                <th scope="col">Wtorek (15.10)</th>
                                <th scope="col">Środa (16.10)</th>
                                <th scope="col">Czwartek (17.10)</th>
                                <th scope="col">Piątek (18.10 - Dziś)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Wiersz 1: Piotr Kowalski -->
                            <tr>
                                <td>
                                    <div class="flex-row">
                                        <div class="avatar-circle">
                                            <i class="fa-solid fa-user-gear"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Piotr Kowalski</div>
                                            <div class="text-xs text-muted">Lead Tech • SEP E1+D1, UDT</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done" title="Zakończono">
                                        <div class="font-bold">#WO-8801</div>
                                        <div class="text-xs">Rewizja V90 Margonin</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8812</div>
                                        <div class="text-xs">Filtracja oleju przekładni</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8840</div>
                                        <div class="text-xs">Kalibracja falownika</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip in-progress">
                                        <div class="font-bold">#WO-8899</div>
                                        <div class="text-xs">Inspekcja łopat wirnika</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip urgent animate-pulse" title="Zadanie Krytyczne na dziś">
                                        <div class="font-bold text-red">#WO-8911 (P1)</div>
                                        <div class="text-xs">Niski poziom oleju Margonin</div>
                                        <div class="text-xs font-mono font-bold mt-xs">14:00 - 18:00</div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Wiersz 2: Marek Nowak -->
                            <tr>
                                <td>
                                    <div class="flex-row">
                                        <div class="avatar-circle">
                                            <i class="fa-solid fa-wrench"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Marek Nowak</div>
                                            <div class="text-xs text-muted">Technik Serwisu • Windy i Dźwigi</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8799</div>
                                        <div class="text-xs">Winda KONE B3 Poznań</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8814</div>
                                        <div class="text-xs">Próba chwytaczy UDT</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8833</div>
                                        <div class="text-xs">Wymiana suwaków kabinowych</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip in-progress">
                                        <div class="font-bold">#WO-8902</div>
                                        <div class="text-xs">Naprawa falownika drzwi</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip in-progress">
                                        <div class="font-bold">#WO-8902</div>
                                        <div class="text-xs">Testy końcowe Pixel Poznań</div>
                                        <div class="text-xs font-mono mt-xs">13:00 - 16:30</div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Wiersz 3: Tomasz Wiśniewski -->
                            <tr>
                                <td>
                                    <div class="flex-row">
                                        <div class="avatar-circle">
                                            <i class="fa-solid fa-laptop-code"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Tomasz Wiśniewski</div>
                                            <div class="text-xs text-muted">Diagnosta IoT &amp; Automatyk</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8804</div>
                                        <div class="text-xs">Wdrożenie czujników Modbus</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8820</div>
                                        <div class="text-xs">Kalibracja bramki IoT</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip standby">
                                        <div class="font-bold">DYŻUR UR</div>
                                        <div class="text-xs">Gotowość Baza Poznań</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip done">
                                        <div class="font-bold">#WO-8890</div>
                                        <div class="text-xs">Analiza wibracji FFT</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="gantt-task-chip assigned" title="Zlecenie przypisane przez asystenta AI">
                                        <div class="font-bold text-blue">#WO-8850 (Przydział AI)</div>
                                        <div class="text-xs">Kaeser SK 22 Solaris Bolechowo</div>
                                        <div class="text-xs font-mono mt-xs">14:30 - 17:30</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        <?php else: ?>
            <!-- ZAKŁADKA 2: TERMINARZ DOZORU UDT I CRON MONITOR (ZUNIFIKOWANY) -->
            <section class="card-block mb-lg" style="border-left: 4px solid var(--clr-blue); background: var(--clr-blue-subtle);">
                <div class="flex-between flex-wrap gap-md">
                    <div class="flex-row">
                        <i class="fa-solid fa-robot text-blue text-2xl"></i>
                        <div>
                            <h2 class="text-sm font-bold text-blue">Automatyzacja CRON: Monitor Badań Okresowych UDT</h2>
                            <p class="text-xs text-muted mt-xs">
                                Skrypt harmonogramu sprawdza codziennie o 06:00 urządzenia z terminem inspekcji &lt; 7 dni, wysyła alerty e-mail (Mailpit) i zapisuje logi w tabeli <code>reminder_logs</code>.
                            </p>
                        </div>
                    </div>
                    <span class="meta-pill text-xs">
                        <i class="fa-solid fa-check text-green"></i> Ostatni skrypt CRON: dzisiaj 06:00 (Status: Sukces)
                    </span>
                </div>
            </section>

            <section class="data-table-container">
                <div class="table-toolbar">
                    <div class="table-search">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <input type="text" placeholder="Szukaj badania, numeru księgi UDT..." aria-label="Szukaj badania UDT">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table" aria-label="Rejestr badań UDT">
                        <thead>
                            <tr>
                                <th scope="col">Termin rewizji</th>
                                <th scope="col">Urządzenie</th>
                                <th scope="col">Księga UDT</th>
                                <th scope="col">Zakres badania</th>
                                <th scope="col">Status terminu</th>
                                <th scope="col">Przypisany inspektor</th>
                                <th scope="col" class="text-right">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-bold text-red">2026-11-15</td>
                                <td>
                                    <a href="/assets/2" class="font-bold text-blue">Winda Osobowa KONE B3</a>
                                    <div class="text-muted text-xs">Biurowiec Pixel, Poznań</div>
                                </td>
                                <td><span class="badge-serial">UDT-POZ-ELEV-9941</span></td>
                                <td>Roczna Rewizja Okresowa UTB (próba chwytaczy)</td>
                                <td><span class="badge-red"><i class="fa-solid fa-clock"></i> Za 3 dni (CRON Alert)</span></td>
                                <td>Piotr Kowalski</td>
                                <td class="text-right">
                                    <a href="/assets/2" class="btn-primary btn-sm">Realizuj</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-bold text-red">2026-11-20</td>
                                <td>
                                    <a href="/assets/1" class="font-bold text-blue">Turbina Wiatrowa V90 #04</a>
                                    <div class="text-muted text-xs">Farma Margonin</div>
                                </td>
                                <td><span class="badge-serial">UDT-POZ-7712/2021</span></td>
                                <td>Rewizja łopat i próba zabezpieczeń prędkościowych</td>
                                <td><span class="badge-red"><i class="fa-solid fa-clock"></i> Za 8 dni</span></td>
                                <td>Piotr Kowalski</td>
                                <td class="text-right">
                                    <a href="/assets/1" class="btn-primary btn-sm">Realizuj</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2026-12-05</td>
                                <td>
                                    <a href="/assets/3" class="font-bold text-blue">Sprężarka Atlas Copco GA 75</a>
                                    <div class="text-muted text-xs">Solaris Bus Bolechowo</div>
                                </td>
                                <td><span class="badge-serial">UDT-POZ-ZB-3129</span></td>
                                <td>Przegląd zbiornika ciśnieniowego bufora</td>
                                <td><span class="badge-amber">Za 23 dni</span></td>
                                <td>Marek Nowak</td>
                                <td class="text-right">
                                    <a href="/assets/3" class="btn-secondary btn-sm">Paszport EAM</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>

    </main>
</body>
</html>
