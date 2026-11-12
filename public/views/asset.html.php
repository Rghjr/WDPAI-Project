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
        
        <!-- Pasek powrotu i szybkich akcji -->
        <div class="flex-between mb-lg">
            <a href="/assets" class="btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Wróć do parku maszynowego
            </a>
            <div class="flex-row">
                <button type="button" class="btn-secondary btn-sm" onclick="window.print()">
                    <i class="fa-solid fa-file-pdf" aria-hidden="true"></i> Drukuj paszport DTR
                </button>
                <a href="/tickets/add" class="btn-primary btn-sm">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Zgłoś awarię tej maszyny
                </a>
            </div>
        </div>

        <!-- Układ dwukolumnowy paszportu EAM -->
        <div class="detail-layout">
            
            <!-- Lewa kolumna: Dane techniczne, dozór UDT, historia awarii -->
            <div class="detail-main">
                
                <!-- Karta nagłówkowa maszyny -->
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <div>
                            <span class="task-id">EAM Asset Passport #<?= htmlspecialchars((string) $assetId) ?></span>
                            <h1 class="text-xl font-extrabold flex-row">
                                <i class="fa-solid fa-industry text-blue" aria-hidden="true"></i>
                                <?= htmlspecialchars($asset['name']) ?>
                            </h1>
                        </div>
                        <div>
                            <?php if ($asset['status'] === 'AWARIA'): ?>
                                <span class="badge-red"><i class="fa-solid fa-triangle-exclamation"></i> AWARIA</span>
                            <?php elseif ($asset['status'] === 'W_NAPRAWIE'): ?>
                                <span class="badge-amber"><i class="fa-solid fa-clock"></i> W NAPRAWIE</span>
                            <?php else: ?>
                                <span class="badge-green"><i class="fa-solid fa-circle-check"></i> OPERACYJNA</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Numer seryjny (S/N)</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($asset['serialNumber']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Kategoria floty</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['category']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Właściciel / Klient</div>
                            <div class="meta-value font-bold"><?= htmlspecialchars($asset['clientName']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Lokalizacja i sektor</div>
                            <div class="meta-value text-xs text-muted">
                                <i class="fa-solid fa-location-dot text-red"></i>
                                <?= htmlspecialchars($asset['location']) ?>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Specyfikacja techniczna i DTR -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-sliders" aria-hidden="true"></i> Specyfikacja Techniczna i Metryka DTR</h2>
                    
                    <div class="meta-grid mt-md">
                        <div class="meta-item">
                            <div class="meta-label">Producent urządzenia</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['manufacturer']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Model i seria</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['model']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Rok produkcji / Uruchomienie</div>
                            <div class="meta-value"><?= htmlspecialchars((string) $asset['productionYear']) ?> (Oddano: <?= htmlspecialchars($asset['commissioningDate']) ?>)</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Moc znamionowa</div>
                            <div class="meta-value font-bold text-blue"><?= htmlspecialchars($asset['powerRating']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Napięcie i zasilanie</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($asset['operatingVoltage']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Łączny czas pracy (Motogodziny)</div>
                            <div class="meta-value font-mono font-bold"><?= number_format((float) $asset['operatingHours'], 0, ',', ' ') ?> h</div>
                        </div>
                    </div>
                </section>

                <!-- Dozór techniczny i UDT -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Status Dozoru Technicznego (UDT)</h2>
                    
                    <div class="meta-grid mt-md">
                        <div class="meta-item">
                            <div class="meta-label">Numer księgi rewizyjnej UDT</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($asset['udtNumber']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Data ostatniego badania</div>
                            <div class="meta-value"><?= htmlspecialchars($asset['lastInspectionDate']) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Termin kolejnego badania okresowego</div>
                            <div class="meta-value font-bold <?= (strtotime($asset['nextInspectionDate']) < strtotime('+14 days') ? 'text-red' : 'text-green') ?>">
                                <i class="fa-solid fa-calendar-day"></i> <?= htmlspecialchars($asset['nextInspectionDate']) ?>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Decyzja zezwalająca na eksploatację</div>
                            <div class="meta-value text-green font-bold">Ważna do: <?= htmlspecialchars($asset['udtDecisionValidUntil']) ?></div>
                        </div>
                    </div>
                </section>

                <!-- Historia awarii i incydentów dla tej maszyny -->
                <section class="card-block">
                    <div class="flex-between mb-md">
                        <h2><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i> Historia Awarii i Zleceń Serwisowych</h2>
                        <a href="/tickets/add" class="btn-primary btn-sm">
                            <i class="fa-solid fa-plus"></i> Nowe zgłoszenie
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table" aria-label="Historia awarii maszyny">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Data zgłoszenia</th>
                                    <th scope="col">Tytuł usterki</th>
                                    <th scope="col">Serwisant</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-right">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($asset['activeTicketId'])): ?>
                                    <tr>
                                        <td class="font-mono">#<?= htmlspecialchars((string) $asset['activeTicketId']) ?></td>
                                        <td>2026-10-22</td>
                                        <td class="font-bold">Niski poziom oleju w przekładni głównej, przegrzanie</td>
                                        <td>Piotr Kowalski</td>
                                        <td><span class="badge-amber"><i class="fa-solid fa-clock"></i> W TRAKCIE</span></td>
                                        <td class="text-right">
                                            <a href="/tickets/<?= htmlspecialchars((string) $asset['activeTicketId']) ?>" class="btn-primary btn-sm">
                                                Podgląd zlecenia &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="font-mono">#108</td>
                                    <td>2026-05-12</td>
                                    <td>Okresowy przegląd roczny, wymiana filtrów hydraulicznych</td>
                                    <td>Marek Nowak</td>
                                    <td><span class="badge-green"><i class="fa-solid fa-check"></i> ROZWIĄZANE</span></td>
                                    <td class="text-right">
                                        <a href="/tickets/1" class="btn-secondary btn-sm">
                                            Szczegóły
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-mono">#089</td>
                                    <td>2025-11-04</td>
                                    <td>Kalibracja czujników wibracji FFT oraz przetwornika ciśnienia</td>
                                    <td>Piotr Kowalski</td>
                                    <td><span class="badge-green"><i class="fa-solid fa-check"></i> ROZWIĄZANE</span></td>
                                    <td class="text-right">
                                        <a href="/tickets/1" class="btn-secondary btn-sm">
                                            Szczegóły
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <!-- Prawa kolumna: Telemetria na żywo, dokumentacja DTR, opiekun -->
            <aside class="detail-sidebar">
                
                <!-- Telemetria IoT na żywo -->
                <div class="ai-diagnosis-widget mb-lg">
                    <div class="ai-header">
                        <div class="ai-badge">
                            <i class="fa-solid fa-tower-broadcast" aria-hidden="true"></i> IoT Telemetry Hub
                        </div>
                        <span class="ai-confidence">Live MQTT 50Hz</span>
                    </div>

                    <p class="text-sm text-muted mb-md">
                        Aktualne pomiary z przemysłowej magistrali Modbus / IoT zainstalowanej na maszynie:
                    </p>

                    <div class="telemetry-box">
                        <div class="telemetry-item">
                            <span class="telemetry-label">Temperatura łożyska</span>
                            <span class="telemetry-val text-red">
                                <?= htmlspecialchars((string) $asset['tempSensor']) ?> °C
                                <i class="fa-solid fa-arrow-trend-up"></i>
                            </span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">Wibracje osiowe FFT</span>
                            <span class="telemetry-val text-green">
                                <?= htmlspecialchars((string) $asset['vibrationSensor']) ?> mm/s RMS
                            </span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">Ciśnienie w układzie</span>
                            <span class="telemetry-val text-blue">
                                <?= htmlspecialchars((string) $asset['pressureSensor']) ?> bar
                            </span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">Wskaźnik MTBF</span>
                            <span class="telemetry-val">840 h bezawaryjnie</span>
                        </div>
                    </div>

                    <button type="button" class="btn-ai btn-sm btn-full mt-md" onclick="alert('Odczytano bieżące pakiety telemetryczne z bramki IoT w Margoninie.')">
                        <i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i> Odśwież telemetrię
                    </button>
                </div>

                <!-- Dokumentacja DTR i schematy -->
                <div class="card-block mb-lg">
                    <h2><i class="fa-solid fa-folder-open" aria-hidden="true"></i> Dokumentacja DTR i Pliki</h2>
                    <ul class="file-list mt-md">
                        <li class="file-item">
                            <div class="flex-row">
                                <i class="fa-solid fa-file-pdf text-red text-lg"></i>
                                <div>
                                    <div class="font-bold text-sm">Instrukcja DTR_V90_v3.pdf</div>
                                    <div class="text-xs text-muted">14.8 MB • Dokumentacja producenta</div>
                                </div>
                            </div>
                            <a href="#" class="btn-secondary btn-sm" onclick="alert('Pobieranie dokumentacji DTR...')">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </li>
                        <li class="file-item">
                            <div class="flex-row">
                                <i class="fa-solid fa-file-waveform text-blue text-lg"></i>
                                <div>
                                    <div class="font-bold text-sm">Schemat_Elektryczny_E04.pdf</div>
                                    <div class="text-xs text-muted">6.2 MB • Rozdzielnica 690V</div>
                                </div>
                            </div>
                            <a href="#" class="btn-secondary btn-sm" onclick="alert('Pobieranie schematu elektrycznego...')">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </li>
                        <li class="file-item">
                            <div class="flex-row">
                                <i class="fa-solid fa-stamp text-amber text-lg"></i>
                                <div>
                                    <div class="font-bold text-sm">Protokol_UDT_Rewizja_2026.pdf</div>
                                    <div class="text-xs text-muted">2.1 MB • Podpisany cyfrowo</div>
                                </div>
                            </div>
                            <a href="#" class="btn-secondary btn-sm" onclick="alert('Pobieranie protokołu UDT...')">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Przypisany główny inżynier / technik -->
                <div class="card-block">
                    <h2><i class="fa-solid fa-user-shield" aria-hidden="true"></i> Opiekun Techniczny</h2>
                    <div class="user-profile-preview mt-md">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <div class="font-bold"><?= htmlspecialchars($asset['assignedTechnician']) ?></div>
                            <div class="text-xs text-muted">Dział Utrzymania Ruchu • Rejon Wielkopolska</div>
                            <div class="text-xs text-blue mt-xs">
                                <i class="fa-solid fa-phone"></i> +48 601 234 567
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
