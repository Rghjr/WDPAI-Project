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
        
        <!-- P1 Critical AI Incident Banner (Zgodnie z projektem Stitch AI) -->
        <section class="ai-p1-banner mb-lg">
            <div class="ai-p1-accent-stripe"></div>
            <div class="ai-p1-content">
                <div class="flex-row gap-md">
                    <div class="ai-p1-icon-badge">
                        <i class="fa-solid fa-triangle-exclamation text-red text-xl"></i>
                    </div>
                    <div>
                        <div class="flex-row flex-wrap gap-xs mb-xs">
                            <span class="badge-red text-xs font-bold uppercase tracking-wider">Krytyczny Alert AI P1</span>
                            <span class="font-mono text-xs font-semibold"><?= htmlspecialchars($criticalIncident['assetCode']) ?></span>
                            <span class="text-muted">•</span>
                            <span class="text-xs text-muted"><?= htmlspecialchars($criticalIncident['location']) ?></span>
                        </div>
                        <h1 class="text-lg font-extrabold text-main leading-tight">
                            <?= htmlspecialchars($criticalIncident['anomalyTitle']) ?>
                        </h1>
                    </div>
                </div>

                <div class="ai-p1-actions">
                    <div class="confidence-pill">
                        <i class="fa-solid fa-brain text-ai"></i>
                        <span>Pewność AI: <strong><?= htmlspecialchars((string) $criticalIncident['confidence']) ?>%</strong></span>
                    </div>
                    <a href="/tickets/add" class="btn-primary btn-sm">
                        <i class="fa-solid fa-wrench"></i> Utwórz zlecenie natychmiast
                    </a>
                </div>
            </div>
        </section>

        <!-- Kafelki KPI Analityki Predykcyjnej -->
        <section class="stats-grid mb-lg" aria-label="Wskaźniki AI">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Średni MTBF Floty</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-chart-line"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= htmlspecialchars((string) $fleetMtbfHours) ?> h</div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-clock-rotate-left"></i> Czas bezawaryjnej pracy urządzeń</div>
            </div>

            <div class="stat-card critical">
                <div class="stat-card__top">
                    <span class="stat-card__title">Wykryte Anomalie (24h)</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-bug"></i></span>
                </div>
                <div class="stat-card__value text-red"><?= htmlspecialchars((string) $predictedAnomaliesCount) ?></div>
                <div class="stat-card__desc text-red"><i class="fa-solid fa-triangle-exclamation"></i> Wymagana interwencja prewencyjna</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywne Sensory CAN/IoT</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-tower-broadcast"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= htmlspecialchars((string) $activeSensorsCount) ?></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Telemetria 50Hz online</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Skuteczność Modelu Ollama</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-brain"></i></span>
                </div>
                <div class="stat-card__value text-ai"><?= htmlspecialchars((string) $aiAccuracyRate) ?> %</div>
                <div class="stat-card__desc text-ai"><i class="fa-solid fa-check-double"></i> Model: Llama-3-AssetFix-8B</div>
            </div>
        </section>

        <!-- Układ Dwukolumnowy: Analiza Spektralna FFT + Wnioskowanie LLM -->
        <div class="detail-layout">
            
            <!-- Lewa Kolumna: FFT Spektrogram, sensory i czas RUL -->
            <div class="detail-main">
                
                <!-- Wykres Widma Drgań FFT -->
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <div>
                            <span class="task-id">Analiza Spektralna Wibracji (FFT Spectral Decomposition)</span>
                            <h2 class="text-lg font-bold">Wykres Częstotliwościowy Drgań Łożyska (ISO 10816-3)</h2>
                        </div>
                        <span class="meta-pill text-xs">
                            <i class="fa-solid fa-wave-square text-ai"></i> Okno Hanninga • 1024 próbki
                        </span>
                    </div>

                    <!-- Symulacja wykresu FFT słupkowego ze wskaźnikami pików harmonicznych -->
                    <div class="fft-chart-box">
                        <div class="fft-threshold-line" title="Dopuszczalna norma ISO: 2.8 mm/s RMS">
                            <span>Próg Alarmowy ISO (2.8 mm/s)</span>
                        </div>

                        <div class="fft-bars-container">
                            <div class="fft-bar-col" style="height: 35%;">
                                <span class="fft-bar-val">1.2</span>
                                <div class="fft-bar"></div>
                                <span class="fft-label">25Hz (1X)</span>
                            </div>
                            <div class="fft-bar-col" style="height: 25%;">
                                <span class="fft-bar-val">0.9</span>
                                <div class="fft-bar"></div>
                                <span class="fft-label">50Hz (2X)</span>
                            </div>
                            <div class="fft-bar-col" style="height: 40%;">
                                <span class="fft-bar-val">1.4</span>
                                <div class="fft-bar"></div>
                                <span class="fft-label">100Hz</span>
                            </div>
                            <div class="fft-bar-col critical" style="height: 92%;">
                                <span class="fft-bar-val text-red font-bold">5.8</span>
                                <div class="fft-bar red animate-pulse"></div>
                                <span class="fft-label text-red font-bold">142Hz (BPFO)</span>
                            </div>
                            <div class="fft-bar-col" style="height: 48%;">
                                <span class="fft-bar-val">1.7</span>
                                <div class="fft-bar"></div>
                                <span class="fft-label">284Hz (2xBPFO)</span>
                            </div>
                            <div class="fft-bar-col" style="height: 30%;">
                                <span class="fft-bar-val">1.1</span>
                                <div class="fft-bar"></div>
                                <span class="fft-label">400Hz</span>
                            </div>
                        </div>
                    </div>

                    <div class="meta-grid mt-md">
                        <div class="meta-item">
                            <div class="meta-label">Amplituda Szczytowa (Peak-to-Peak)</div>
                            <div class="meta-value font-mono text-red font-bold">5.8 mm/s RMS (Przekroczenie o 107%)</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Zidentyfikowana Częstotliwość Usterki</div>
                            <div class="meta-value font-mono">142.4 Hz (BPFO – Bieżnia Zewnętrzna)</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Szacowany Czas Do Awarii (RUL)</div>
                            <div class="meta-value font-bold text-red"><i class="fa-solid fa-hourglass-half"></i> &lt; 4 godz. 15 min</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Zalecenie Obciążeniowe falownika</div>
                            <div class="meta-value text-amber font-bold">Obniż obroty do 50% (Tryb Awaryjny)</div>
                        </div>
                    </div>
                </article>

                <!-- Historia trendu parametrów 24h -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-chart-area" aria-hidden="true"></i> Trend Telemetryczny 24h (Korelacja Temp / Ciśnienie)</h2>
                    
                    <div class="table-responsive mt-md">
                        <table class="data-table" aria-label="Odczyty telemetrii z ostatnich godzin">
                            <thead>
                                <tr>
                                    <th scope="col">Godzina odczytu</th>
                                    <th scope="col">Drgania RMS</th>
                                    <th scope="col">Temp. Łożyska</th>
                                    <th scope="col">Ciśnienie w układzie</th>
                                    <th scope="col">Status predykcji</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-mono">14:00 (Aktualny)</td>
                                    <td class="text-red font-bold">5.8 mm/s</td>
                                    <td class="text-red font-bold">78.4 °C</td>
                                    <td class="text-amber font-bold">11.2 bar</td>
                                    <td><span class="badge-red">P1 ALARM KRYTYCZNY</span></td>
                                </tr>
                                <tr>
                                    <td class="font-mono">13:00</td>
                                    <td class="text-amber font-bold">4.2 mm/s</td>
                                    <td class="text-amber">71.0 °C</td>
                                    <td>13.8 bar</td>
                                    <td><span class="badge-amber">OSTRZEŻENIE</span></td>
                                </tr>
                                <tr>
                                    <td class="font-mono">12:00</td>
                                    <td>2.6 mm/s</td>
                                    <td>65.1 °C</td>
                                    <td>14.1 bar</td>
                                    <td><span class="badge-green">NORMA</span></td>
                                </tr>
                                <tr>
                                    <td class="font-mono">10:00</td>
                                    <td>1.8 mm/s</td>
                                    <td>58.4 °C</td>
                                    <td>14.4 bar</td>
                                    <td><span class="badge-green">NORMA</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <!-- Prawa Kolumna: Wnioskowanie Ollama LLM i Rekomendacje Części -->
            <aside class="detail-sidebar">
                
                <!-- Karta Modelu Ollama LLM -->
                <div class="card-block mb-lg" style="border: 1px solid var(--clr-ai-border); background: var(--clr-ai-bg);">
                    <div class="flex-between mb-sm">
                        <div class="flex-row">
                            <i class="fa-solid fa-brain text-ai text-lg"></i>
                            <h2 class="text-sm font-bold text-ai">Ollama LLM Root-Cause Analysis</h2>
                        </div>
                        <span class="ai-confidence">94% Confidence</span>
                    </div>

                    <p class="text-xs text-muted mb-sm">
                        Model: <strong>Llama-3-AssetFix-8B-Q4</strong> • Kontekst: Odczyty sensorów CAN-bus + Historia awarii EAM.
                    </p>

                    <div class="ai-insight-box">
                        <div class="font-bold text-sm mb-xs text-main">Diagnoza Przyczyny Źródłowej:</div>
                        <p class="text-xs leading-relaxed text-muted">
                            Wykryto postępujący pitting i wykruszenie bieżni zewnętrznej łożyska tocznego <strong>SKF 6314</strong> na wale napędowym sprężarki Kaeser SK 22. Charakterystyczny pik 142 Hz (BPFO) oraz gwałtowny wzrost temperatury do 78.4°C wykluczają problem niewyważenia wirnika.
                        </p>
                    </div>

                    <div class="mt-md">
                        <div class="font-bold text-xs mb-xs uppercase tracking-wider text-muted">Zalecana Procedura Naprawcza:</div>
                        <ol class="text-xs text-muted space-y-1 pl-4" style="line-height: 1.6;">
                            <li>Natychmiastowe obniżenie obciążenia i przygotowanie do planowego zatrzymania.</li>
                            <li>Wymiana zespołu łożyskowego (SKF 6314-2Z/C3) wraz z uszczelnieniem Viton.</li>
                            <li>Płukanie układu smarowania i wymiana wkładu filtra oleju (filtr 10 µm).</li>
                            <li>Kontrolny pomiar wibroakustyczny FFT po uruchomieniu (oczekiwany RMS &lt; 1.5 mm/s).</li>
                        </ol>
                    </div>

                    <button type="button" class="btn-ai btn-sm btn-full mt-md" onclick="alert('Diagnoza modelu Ollama została dołączona do zlecenia serwisowego #WO-8850. Technik otrzymał powiadomienie z procedurą.')">
                        <i class="fa-solid fa-paper-plane"></i> Przekaż diagnozę do zlecenia
                    </button>
                </div>

                <!-- Rekomendowany Zestaw Części Zamiennych OEM -->
                <div class="card-block">
                    <h2><i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i> Części Zamienne i Magazyn Baza Poznań</h2>
                    <p class="text-xs text-muted mb-md">
                        Automatyczne dopasowanie części z katalogu OEM na podstawie numeru seryjnego maszyny:
                    </p>

                    <ul class="file-list">
                        <li class="file-item">
                            <div>
                                <div class="font-bold text-sm">Łożysko Tooczne SKF 6314-2Z/C3</div>
                                <div class="text-xs text-muted font-mono">OEM: 1613-9001-00 • Magazyn Poznań: <strong>2 szt.</strong></div>
                            </div>
                            <span class="badge-green text-xs">DOSTĘPNE</span>
                        </li>
                        <li class="file-item">
                            <div>
                                <div class="font-bold text-sm">Zestaw Uszczelek FKM Viton</div>
                                <div class="text-xs text-muted font-mono">OEM: 2901-0503-00 • Magazyn Poznań: <strong>4 kpl.</strong></div>
                            </div>
                            <span class="badge-green text-xs">DOSTĘPNE</span>
                        </li>
                        <li class="file-item">
                            <div>
                                <div class="font-bold text-sm">Olej Syntetyczny SynthGear 320 (20L)</div>
                                <div class="text-xs text-muted font-mono">OEM: 1630-0075-00 • Magazyn Poznań: <strong>40 L</strong></div>
                            </div>
                            <span class="badge-green text-xs">DOSTĘPNE</span>
                        </li>
                    </ul>

                    <button type="button" class="btn-secondary btn-sm btn-full mt-md" onclick="alert('Zarezerwowano 1x Łożysko SKF, 1x Zestaw uszczelek oraz 20L oleju na regale R-14 w Bazie Poznań.')">
                        <i class="fa-solid fa-cart-flatbed"></i> Zarezerwuj komplet naprawczy
                    </button>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
