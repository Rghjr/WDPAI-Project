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
        
        <!-- Pasek powrotu -->
        <div class="flex-between mb-lg">
            <a href="/" class="btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Wróć do pulpitu operacyjnego
            </a>
            <div class="flex-row">
                <button type="button" class="btn-secondary btn-sm" onclick="window.print()">
                    <i class="fa-solid fa-id-badge" aria-hidden="true"></i> Drukuj legitymację serwisanta
                </button>
                <a href="/login" class="btn-primary btn-sm">
                    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> Wyloguj
                </a>
            </div>
        </div>

        <!-- Układ profilu serwisanta -->
        <div class="detail-layout">
            
            <!-- Lewa kolumna: Dane pracownika, uprawnienia państwowe, zmiana hasła -->
            <div class="detail-main">
                
                <!-- Karta tożsamości -->
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <div class="flex-row">
                            <div class="avatar-circle" style="width: 54px; height: 54px; font-size: 1.5rem;">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                            <div>
                                <span class="task-id">Legitymacja Serwisowa #<?= htmlspecialchars($employeeId) ?></span>
                                <h1 class="text-xl font-extrabold"><?= htmlspecialchars($name) ?></h1>
                                <p class="text-xs text-muted font-semibold"><?= htmlspecialchars($roleTitle) ?></p>
                            </div>
                        </div>
                        <div>
                            <span class="badge-blue font-bold"><i class="fa-solid fa-circle-check"></i> ROZLICZONY (AKTYWNY)</span>
                        </div>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Adres e-mail</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($email) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Telefon alarmowy</div>
                            <div class="meta-value font-bold text-blue"><?= htmlspecialchars($phone) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Baza macierzysta</div>
                            <div class="meta-value"><?= htmlspecialchars($baseLocation) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">W zespole od</div>
                            <div class="meta-value"><?= htmlspecialchars($hireDate) ?></div>
                        </div>
                    </div>
                </article>

                <!-- Certyfikaty państwowe i uprawnienia techniczne -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-certificate" aria-hidden="true"></i> Certyfikaty i Uprawnienia Państwowe</h2>
                    <p class="text-xs text-muted mb-md">
                        Weryfikacja kwalifikacji wymaganych przez Urząd Dozoru Technicznego (UDT) oraz Stowarzyszenie Elektryków Polskich (SEP).
                    </p>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="flex-between">
                                <span class="font-bold text-sm">Świadectwo Kwalifikacyjne SEP E1 + D1</span>
                                <span class="badge-green text-xs">Ważne</span>
                            </div>
                            <div class="text-xs text-muted mt-xs">Eksploatacja i Dozór instalacji do 1 kV • Nr: SEP-POZ-91823</div>
                            <div class="text-xs font-semibold mt-xs text-green"><i class="fa-solid fa-calendar-check"></i> Ważne do: 2028-06-15</div>
                        </div>

                        <div class="meta-item">
                            <div class="flex-between">
                                <span class="font-bold text-sm">Uprawnienia UDT – Konserwator UTB</span>
                                <span class="badge-green text-xs">Ważne</span>
                            </div>
                            <div class="text-xs text-muted mt-xs">Dźwigi osobowe, wciągniki, żurawie stacjonarne • Nr: UDT-W-4412</div>
                            <div class="text-xs font-semibold mt-xs text-green"><i class="fa-solid fa-calendar-check"></i> Ważne do: 2029-01-20</div>
                        </div>

                        <div class="meta-item">
                            <div class="flex-between">
                                <span class="font-bold text-sm">Prace Wysokościowe IRATA Level 1</span>
                                <span class="badge-green text-xs">Ważne</span>
                            </div>
                            <div class="text-xs text-muted mt-xs">Dostęp linowy i asekuracja na masztach wiatrowych • Nr: IR-77291</div>
                            <div class="text-xs font-semibold mt-xs text-green"><i class="fa-solid fa-calendar-check"></i> Ważne do: 2027-11-04</div>
                        </div>

                        <div class="meta-item">
                            <div class="flex-between">
                                <span class="font-bold text-sm">Diagnostyka AI Ollama &amp; Telemetria</span>
                                <span class="badge-blue text-xs">Certyfikat B2B</span>
                            </div>
                            <div class="text-xs text-muted mt-xs">Interpretacja widm wibracji FFT i modeli awaryjności • AssetFix AI</div>
                            <div class="text-xs font-semibold mt-xs text-blue"><i class="fa-solid fa-brain"></i> Bezterminowy</div>
                        </div>
                    </div>
                </section>

                <!-- Bezpieczeństwo konta i zmiana hasła -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-lock" aria-hidden="true"></i> Bezpieczeństwo i Zmiana Hasła</h2>
                    <form action="/profile" method="POST" onsubmit="event.preventDefault(); alert('Hasło zostało pomyślnie zaktualizowane (hashowanie bcrypt/argon2id).');">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="current_password">Bieżące hasło:</label>
                                <input type="password" id="current_password" name="current_password" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nowe hasło (min. 8 znaków):</label>
                                <input type="password" id="new_password" name="new_password" class="form-input" required minlength="8">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary mt-sm">
                            <i class="fa-solid fa-key" aria-hidden="true"></i> Zaktualizuj hasło
                        </button>
                    </form>
                </section>

            </div>

            <!-- Prawa kolumna: Statystyki KPI technika, preferencje, sesje -->
            <aside class="detail-sidebar">
                
                <!-- Statystyki wykonawcze technika -->
                <div class="card-block mb-lg">
                    <h2><i class="fa-solid fa-chart-pie text-blue" aria-hidden="true"></i> Efektywność Serwisanta</h2>
                    
                    <div class="telemetry-box mt-md">
                        <div class="telemetry-item">
                            <span class="telemetry-label">Rozwiązane zlecenia</span>
                            <span class="telemetry-val text-green font-bold"><?= htmlspecialchars((string) $completedTicketsCount) ?></span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">First-Time Fix Rate</span>
                            <span class="telemetry-val text-blue font-bold"><?= htmlspecialchars((string) $firstTimeFixRate) ?> %</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">Średni czas naprawy</span>
                            <span class="telemetry-val"><?= htmlspecialchars((string) $avgRepairHours) ?> godz.</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-label">Zgodność z SLA</span>
                            <span class="telemetry-val text-green font-bold"><?= htmlspecialchars((string) $slaComplianceRate) ?> %</span>
                        </div>
                    </div>
                </div>

                <!-- Preferencje powiadomień -->
                <div class="card-block mb-lg">
                    <h2><i class="fa-solid fa-bell" aria-hidden="true"></i> Preferencje Powiadomień</h2>
                    
                    <div class="mt-md flex-col" style="gap: 12px;">
                        <label class="flex-row text-sm" style="cursor: pointer;">
                            <input type="checkbox" checked>
                            <span>Alerty SMS przy awariach krytycznych (2H SLA)</span>
                        </label>
                        <label class="flex-row text-sm" style="cursor: pointer;">
                            <input type="checkbox" checked>
                            <span>Poranne podsumowanie planu dnia o 06:30</span>
                        </label>
                        <label class="flex-row text-sm" style="cursor: pointer;">
                            <input type="checkbox" checked>
                            <span>Automatyczna podpowiedź AI Ollama w zgłoszeniach</span>
                        </label>
                        <label class="flex-row text-sm" style="cursor: pointer;">
                            <input type="checkbox" checked>
                            <span>Powiadomienia o zbliżających się badaniach UDT</span>
                        </label>
                    </div>
                </div>

                <!-- Aktywna sesja -->
                <div class="card-block">
                    <h2><i class="fa-solid fa-shield" aria-hidden="true"></i> Informacje o Sesji</h2>
                    <div class="text-xs text-muted mt-sm flex-col" style="gap: 6px;">
                        <div><i class="fa-solid fa-network-wired"></i> Adres IP: 192.168.1.42 (Baza Poznań)</div>
                        <div><i class="fa-solid fa-clock"></i> Zalogowano: Dzisiaj, 07:15</div>
                        <div><i class="fa-solid fa-fingerprint"></i> Sesja PHP: Zabezpieczona (HttpOnly, SameSite)</div>
                    </div>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
