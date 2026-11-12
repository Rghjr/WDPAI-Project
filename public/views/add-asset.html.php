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
        
        <div class="form-card">
            <header class="form-header">
                <div class="flex-between mb-sm">
                    <a href="/assets" class="btn-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Wróć do listy maszyn
                    </a>
                    <span class="meta-pill">
                        <i class="fa-solid fa-industry"></i> EAM Asset Management
                    </span>
                </div>
                <h1>
                    <i class="fa-solid fa-circle-plus text-blue" aria-hidden="true"></i>
                    <?= htmlspecialchars($pageTitle) ?>
                </h1>
                <p>
                    Wprowadź specyfikację techniczną, dane klienta oraz interwały dozoru technicznego (UDT) nowego zasobu.
                </p>
            </header>

            <form action="/assets" method="POST" enctype="multipart/form-data">
                
                <!-- Sekcja 1: Identyfikacja urządzenia -->
                <fieldset class="form-section">
                    <legend class="font-bold text-sm text-muted mb-md flex-row">
                        <i class="fa-solid fa-tag text-blue"></i> 1. Dane Identyfikacyjne Urządzenia
                    </legend>

                    <div class="form-group">
                        <label for="asset_name">Nazwa urządzenia / maszyny:</label>
                        <input type="text" id="asset_name" name="name" class="form-input" placeholder="np. Sprężarka śrubowa Kaeser SK 22" required>
                        <span class="form-hint">Czytelna nazwa wykorzystywana na zgłoszeniach i w raportach.</span>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="serial_number">Numer seryjny (S/N):</label>
                            <input type="text" id="serial_number" name="serial_number" class="form-input font-mono" placeholder="np. KAS-2026-0084" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategoria floty / Typ zasobu:</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="">-- Wybierz kategorię --</option>
                                <option value="1">OZE / Turbiny Wiatrowe i PV</option>
                                <option value="2">Dźwigi, windy i wciągarki (UTB)</option>
                                <option value="3">HVAC, wentylacja i chłodnictwo</option>
                                <option value="4">Sprężarki i układy pneumatyczne</option>
                                <option value="5">Obrabiarki CNC i linie zautomatyzowane</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="manufacturer">Producent:</label>
                            <input type="text" id="manufacturer" name="manufacturer" class="form-input" placeholder="np. Kaeser Kompressoren SE" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model i seria:</label>
                            <input type="text" id="model" name="model" class="form-input" placeholder="np. SK 22 SFC 11kW" required>
                        </div>
                    </div>
                </fieldset>

                <!-- Sekcja 2: Klient i lokalizacja -->
                <fieldset class="form-section mt-lg">
                    <legend class="font-bold text-sm text-muted mb-md flex-row">
                        <i class="fa-solid fa-location-dot text-red"></i> 2. Przypisanie do Klienta i Lokalizacja
                    </legend>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="client_id">Właściciel / Klient z bazy:</label>
                            <select id="client_id" name="client_id" class="form-select" required>
                                <option value="">-- Wybierz klienta --</option>
                                <option value="1">Polenergia S.A. (Farma Margonin)</option>
                                <option value="2">Biurowiec Pixel Poznań Sp. z o.o.</option>
                                <option value="3">Solaris Bus &amp; Coach Sp. z o.o.</option>
                                <option value="4">Amazon Logistics Poznań (WRO2)</option>
                                <option value="5">Żabka Polska S.A. – Centrum Logistyczne</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location_sector">Sektor / Hala / Dokładna lokalizacja:</label>
                            <input type="text" id="location_sector" name="location" class="form-input" placeholder="np. Hala Produkcyjna B, Sprężarkownia S-1" required>
                        </div>
                    </div>
                </fieldset>

                <!-- Sekcja 3: Dozór techniczny i UDT -->
                <fieldset class="form-section mt-lg">
                    <legend class="font-bold text-sm text-muted mb-md flex-row">
                        <i class="fa-solid fa-shield-halved text-amber"></i> 3. Wymagania Dozoru Technicznego (UDT)
                    </legend>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="udt_number">Numer ewidencyjny księgi UDT (jeśli dotyczy):</label>
                            <input type="text" id="udt_number" name="udt_number" class="form-input font-mono" placeholder="np. UDT-POZ-ZB-9812">
                            <span class="form-hint">Dla urządzeń ciśnieniowych i transportu bliskiego.</span>
                        </div>
                        <div class="form-group">
                            <label for="inspection_interval">Interwał przeglądów okresowych:</label>
                            <select id="inspection_interval" name="inspection_interval" class="form-select" required>
                                <option value="3">Co 3 miesiące (Intensywna eksploatacja)</option>
                                <option value="6">Co 6 miesięcy (Standardowy dla dźwigów)</option>
                                <option value="12" selected>Co 12 miesięcy (Roczny dozór UDT)</option>
                                <option value="24">Co 24 miesiące</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="next_inspection">Termin pierwszego wymaganego badania:</label>
                            <input type="date" id="next_inspection" name="next_inspection" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="assigned_technician">Domyślny opiekun techniczny:</label>
                            <select id="assigned_technician" name="assigned_technician" class="form-select">
                                <option value="1">Piotr Kowalski (Główny Technik)</option>
                                <option value="2">Marek Nowak (Technik Serwisu)</option>
                                <option value="3">Tomasz Wiśniewski (Diagnosta IoT)</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- Sekcja 4: Parametry robocze i dokumentacja -->
                <fieldset class="form-section mt-lg">
                    <legend class="font-bold text-sm text-muted mb-md flex-row">
                        <i class="fa-solid fa-file-pdf text-blue"></i> 4. Parametry Robocze i Dokumentacja DTR
                    </legend>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="power_rating">Moc znamionowa (kW):</label>
                            <input type="text" id="power_rating" name="power_rating" class="form-input" placeholder="np. 22 kW">
                        </div>
                        <div class="form-group">
                            <label for="voltage">Napięcie robocze / zasilanie:</label>
                            <input type="text" id="voltage" name="voltage" class="form-input" placeholder="np. 400 V / 50 Hz">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dtr_file">Załącznik instrukcji DTR lub schematu (PDF do 25 MB):</label>
                        <input type="file" id="dtr_file" name="dtr_file" accept=".pdf" class="form-input">
                        <span class="form-hint">Plik zostanie zapisany w bezpiecznym rejestrze technicznym maszyny.</span>
                    </div>
                </fieldset>

                <!-- Przyciski zapisu -->
                <div class="form-actions mt-xl">
                    <a href="/assets" class="btn-secondary">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i> Anuluj
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Zarejestruj urządzenie w EAM
                    </button>
                </div>

            </form>
        </div>

    </main>
</body>
</html>
