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
        
        <!-- Pasek Kontekstowy i Telemetria CAN-bus (Wzór ze Stitch w3) -->
        <div class="asset-context-bar mb-md">
            <div class="flex-row gap-xs text-xs text-muted">
                <a href="/assets" class="text-muted hover-underline">Park maszynowy</a>
                <span class="text-dim">/</span>
                <span class="text-muted"><?= htmlspecialchars($asset['category']) ?></span>
                <span class="text-dim">/</span>
                <span class="font-mono bg-card px-xs py-0.5 rounded text-main font-semibold">SN: <?= htmlspecialchars($asset['serialNumber']) ?></span>
            </div>

            <div class="flex-row gap-xs font-mono text-xs">
                <span class="text-muted">Ostatni odczyt CAN-bus:</span>
                <span class="font-bold text-main">14:02:18 (teraz)</span>
                <span class="status-dot green animate-pulse"></span>
            </div>
        </div>

        <!-- Nagłówek Urządzenia z Badgami i Przyciskami Akcji -->
        <header class="card-block mb-lg">
            <div class="flex-between flex-wrap gap-md">
                <div>
                    <div class="flex-row flex-wrap gap-sm mb-xs">
                        <h1 class="text-xl font-extrabold text-main">
                            <?= htmlspecialchars($asset['name']) ?>
                        </h1>
                        <span class="text-muted text-sm font-normal">• <?= htmlspecialchars($asset['model']) ?></span>
                    </div>

                    <div class="flex-row flex-wrap gap-xs">
                        <?php if ($asset['status'] === 'AWARIA'): ?>
                            <span class="badge-red"><i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($asset['statusLabel']) ?></span>
                        <?php elseif ($asset['status'] === 'W_NAPRAWIE'): ?>
                            <span class="badge-amber"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($asset['statusLabel']) ?></span>
                        <?php else: ?>
                            <span class="badge-green"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($asset['statusLabel']) ?></span>
                        <?php endif; ?>

                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-tag"></i> Kategoria: <?= htmlspecialchars($asset['category']) ?>
                        </span>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars($asset['clientName']) ?>
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

        <!-- 4 Kafelki Telemetrii na Żywo (Wibracje, Temp, Ciśnienie, Motogodziny) -->
        <section class="stats-grid mb-lg" aria-label="Odczyty sensorów maszyny">
            <div class="stat-card <?= ($asset['tempSensor'] > 65 ? 'critical' : '') ?>">
                <div class="stat-card__top">
                    <span class="stat-card__title">Temperatura łożyska</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-temperature-high"></i></span>
                </div>
                <div class="stat-card__value <?= ($asset['tempSensor'] > 65 ? 'text-red' : 'text-main') ?>">
                    <?= htmlspecialchars((string) $asset['tempSensor']) ?> °C
                </div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-gauge"></i> Norma ISO: &lt; 65 °C (Próg alarmowy 75 °C)
                </div>
            </div>

            <div class="stat-card <?= ($asset['vibrationSensor'] > 2.5 ? 'critical' : '') ?>">
                <div class="stat-card__top">
                    <span class="stat-card__title">Wibracje osiowe FFT</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-wave-square"></i></span>
                </div>
                <div class="stat-card__value <?= ($asset['vibrationSensor'] > 2.5 ? 'text-red' : 'text-green') ?>">
                    <?= htmlspecialchars((string) $asset['vibrationSensor']) ?> mm/s
                </div>
                <div class="stat-card__desc">
                    <i class="fa-solid fa-chart-line"></i> Widmo wibracji FFT (Częstotliwość 142 Hz)
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Ciśnienie w układzie</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-gauge-simple-high"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $asset['pressureSensor']) ?> bar</div>
                <div class="stat-card__desc text-blue"><i class="fa-solid fa-check"></i> Ciśnienie robocze stabilne</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Przepracowane motogodziny</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                </div>
                <div class="stat-card__value text-main font-mono"><?= number_format((float) $asset['operatingHours'], 0, ',', ' ') ?> h</div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-wrench"></i> Następny przegląd za 1 580 h</div>
            </div>
        </section>

        <!-- Główny Układ Paszportu: Specyfikacja i Historia + Prawy Pasek Diagnostyki -->
        <div class="detail-layout">
            
            <!-- Lewa Kolumna: Specyfikacja DTR, Dozór UDT, Historia Incydentów -->
            <div class="detail-main">
                
                <!-- Specyfikacja techniczna DTR -->
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <h2><i class="fa-solid fa-sliders text-blue" aria-hidden="true"></i> Metryka Fabryczna i Parametry Robocze (DTR)</h2>
                        <span class="meta-pill text-xs">Paszport EAM #<?= htmlspecialchars((string) $assetId) ?></span>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Producent urządzenia</div>
                            <div class="meta-value font-bold"><?= htmlspecialchars($asset['manufacturer']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Model i wariant</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['model']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Rok produkcji i data odbioru</div>
                            <div class="meta-value"><?= htmlspecialchars((string) $asset['productionYear']) ?> (Uruchomienie: <?= htmlspecialchars($asset['commissioningDate']) ?>)</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Moc znamionowa silnika</div>
                            <div class="meta-value text-blue font-bold"><?= htmlspecialchars($asset['powerRating']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Zasilanie elektryczne</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($asset['operatingVoltage']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Lokalizacja fizyczna</div>
                            <div class="meta-value text-xs text-muted"><i class="fa-solid fa-location-dot text-red"></i> <?= htmlspecialchars($asset['location']) ?></div>
                        </div>
                    </div>
                </article>

                <!-- Status Dozoru Technicznego UDT -->
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
                            <div class="meta-value font-mono font-bold"><?= htmlspecialchars($asset['udtNumber']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Ostatnie badanie okresowe</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['lastInspectionDate']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Termin kolejnej rewizji UDT</div>
                            <div class="meta-value font-bold <?= (strtotime($asset['nextInspectionDate']) < strtotime('+14 days') ? 'text-red' : 'text-green') ?>">
                                <i class="fa-solid fa-calendar-day"></i> <?= htmlspecialchars($asset['nextInspectionDate']) ?>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Decyzja eksploatacyjna UDT</div>
                            <div class="meta-value text-green font-bold">Ważna do: <?= htmlspecialchars($asset['udtDecisionValidUntil']) ?></div>
                        </div>
                    </div>
                </section>

                <!-- Historia Zleceń i Awarii #WO dla tej maszyny -->
                <section class="card-block">
                    <div class="flex-between mb-md">
                        <h2><i class="fa-solid fa-clipboard-list text-blue" aria-hidden="true"></i> Historia Zleceń Serwisowych #WO</h2>
                        <a href="/tickets/add" class="btn-primary btn-sm">
                            <i class="fa-solid fa-plus"></i> Nowe zlecenie
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table" aria-label="Zlecenia dla tej maszyny">
                            <thead>
                                <tr>
                                    <th scope="col">Zlecenie</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Tytuł problemu</th>
                                    <th scope="col">Serwisant</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-right">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($asset['activeTicketId'])): ?>
                                    <tr>
                                        <td class="font-mono font-bold text-red">#WO-8911</td>
                                        <td>2026-10-22</td>
                                        <td class="font-bold">Niski poziom oleju, wzrost temperatury łożyska</td>
                                        <td><?= htmlspecialchars($asset['assignedTechnician']) ?></td>
                                        <td><span class="badge-amber"><i class="fa-solid fa-clock"></i> W TOKU</span></td>
                                        <td class="text-right">
                                            <a href="/tickets/<?= htmlspecialchars((string) $asset['activeTicketId']) ?>" class="btn-primary btn-sm">Podgląd &rarr;</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="font-mono">#WO-8801</td>
                                    <td>2026-05-12</td>
                                    <td>Przegląd okresowy roczny, wymiana filtrów i uszczelek</td>
                                    <td>Marek Nowak</td>
                                    <td><span class="badge-green"><i class="fa-solid fa-check"></i> ZAMKNIĘTE</span></td>
                                    <td class="text-right">
                                        <a href="/tickets/1" class="btn-secondary btn-sm">Szczegóły</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-mono">#WO-8650</td>
                                    <td>2025-11-04</td>
                                    <td>Kalibracja przetworników ciśnienia i czujników FFT</td>
                                    <td>Piotr Kowalski</td>
                                    <td><span class="badge-green"><i class="fa-solid fa-check"></i> ZAMKNIĘTE</span></td>
                                    <td class="text-right">
                                        <a href="/tickets/1" class="btn-secondary btn-sm">Szczegóły</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <!-- Prawa Kolumna: Diagnostyka AI, Dokumenty DTR i Opiekun -->
            <aside class="detail-sidebar">
                
                <!-- Karta Smart Diagnosis AI dla tej maszyny -->
                <div class="card-block mb-lg" style="border: 1px solid var(--clr-ai-border); background: var(--clr-ai-bg);">
                    <div class="flex-between mb-sm">
                        <div class="flex-row">
                            <i class="fa-solid fa-brain text-ai text-lg"></i>
                            <h2 class="text-sm font-bold text-ai">Ollama Smart Diagnosis AI</h2>
                        </div>
                        <span class="ai-confidence">Live Anomaly</span>
                    </div>

                    <p class="text-xs text-muted mb-md">
                        Analiza odczytów telemetrii z czujników wibracji i temperatury dla urządzenia <?= htmlspecialchars($asset['serialNumber']) ?>:
                    </p>

                    <div class="ai-insight-box">
                        <div class="font-bold text-xs text-red mb-xs"><i class="fa-solid fa-triangle-exclamation"></i> Wykryto ryzyko przegrzania łożyska</div>
                        <p class="text-xs text-muted leading-relaxed">
                            Pomiary FFT wskazują na anomalne piki przy 142 Hz (faza 3 degradacji bieżni). Zalecana inspekcja poziomu oleju oraz wymiana filtra w ciągu 4 godzin roboczych.
                        </p>
                    </div>

                    <a href="/diagnostics" class="btn-ai btn-sm btn-full mt-md">
                        <i class="fa-solid fa-chart-line"></i> Otwórz pełne spektrum FFT
                    </a>
                </div>

                <!-- Pliki DTR i Dokumentacja Techniczna -->
                <div class="card-block mb-lg">
                    <h2><i class="fa-solid fa-folder-open text-blue" aria-hidden="true"></i> Dokumentacja Techniczna DTR</h2>
                    
                    <ul class="file-list mt-md">
                        <li class="file-item">
                            <div class="flex-row">
                                <i class="fa-solid fa-file-pdf text-red text-lg"></i>
                                <div>
                                    <div class="font-bold text-xs">Instrukcja_DTR_<?= htmlspecialchars($asset['serialNumber']) ?>.pdf</div>
                                    <div class="text-xs text-muted">14.8 MB • Dokumentacja producenta</div>
                                </div>
                            </div>
                            <button type="button" class="btn-secondary btn-sm" onclick="alert('Pobieranie dokumentacji DTR...')">
                                <i class="fa-solid fa-download"></i>
                            </button>
                        </li>
                        <li class="file-item">
                            <div class="flex-row">
                                <i class="fa-solid fa-file-waveform text-blue text-lg"></i>
                                <div>
                                    <div class="font-bold text-xs">Schemat_Elektryczny_Rozdzielnicy.pdf</div>
                                    <div class="text-xs text-muted">6.2 MB • Schemat ideowy</div>
                                </div>
                            </div>
                            <button type="button" class="btn-secondary btn-sm" onclick="alert('Pobieranie schematu elektrycznego...')">
                                <i class="fa-solid fa-download"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Opiekun Maszyny -->
                <div class="card-block">
                    <h2><i class="fa-solid fa-user-shield text-blue" aria-hidden="true"></i> Opiekun Techniczny</h2>
                    <div class="user-profile-preview mt-md">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <div class="font-bold text-sm"><?= htmlspecialchars($asset['assignedTechnician']) ?></div>
                            <div class="text-xs text-muted">Dział Utrzymania Ruchu • Aglomeracja Poznań</div>
                            <div class="text-xs text-blue mt-xs"><i class="fa-solid fa-phone"></i> +48 601 234 567</div>
                        </div>
                    </div>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
