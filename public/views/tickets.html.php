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
        
        <!-- Nagłówek modułu zleceń -->
        <header class="dashboard-header" style="margin-bottom: 20px;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-clipboard-list" style="color: var(--clr-blue);" aria-hidden="true"></i>
                    Rejestr Zgłoszeń i Zleceń Serwisowych
                </h1>
                <p class="greeting-subtitle">
                    Zarządzanie incydentami, naprawami i predykcyjną diagnostyką maszyn
                </p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <span class="meta-pill">
                    Liczba otwartych zgłoszeń: <strong style="color: var(--clr-blue); margin-left: 4px;"><?= htmlspecialchars((string) $openTicketsCount) ?></strong>
                </span>
                <a href="/tickets/add" class="btn-primary">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Dodaj nowe zgłoszenie
                </a>
            </div>
        </header>

        <!-- Pasek narzędzi i filtrów tabeli -->
        <div class="data-table-container">
            <div class="table-toolbar">
                <div class="table-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" placeholder="Szukaj po kodzie, maszynie lub usterce..." aria-label="Wyszukaj zlecenie">
                </div>
                <div class="table-filters" role="group" aria-label="Filtry statusu">
                    <button class="filter-btn active" type="button">Wszystkie (3)</button>
                    <button class="filter-btn" type="button">Otwarte (1)</button>
                    <button class="filter-btn" type="button">W toku (1)</button>
                    <button class="filter-btn" type="button">Rozwiązane (1)</button>
                </div>
            </div>

            <!-- Tabela zleceń -->
            <div class="table-responsive">
                <table class="data-table" aria-label="Lista zleceń serwisowych">
                    <thead>
                        <tr>
                            <th scope="col">Kod Zlecenia</th>
                            <th scope="col">Urządzenie &amp; S/N</th>
                            <th scope="col">Tytuł Usterki</th>
                            <th scope="col">Priorytet</th>
                            <th scope="col">Status</th>
                            <th scope="col">Przypisany</th>
                            <th scope="col" style="text-align: right;">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="/tickets/1" class="font-mono" style="font-weight: 700; color: var(--clr-blue);">
                                    #WO-2024-8841
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Turbina Wiatrowa V90 #04</div>
                                <span class="font-mono" style="font-size: 0.75rem; color: var(--clr-text-muted);">TURB-2024-9004</span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Spadek ciśnienia oleju / Wibracja</div>
                                <span style="font-size: 0.75rem; color: var(--clr-text-muted);"><i class="fa-solid fa-wand-magic-sparkles" style="color: var(--clr-ai-primary);"></i> Smart Diagnosis dostępna</span>
                            </td>
                            <td>
                                <span class="badge-red"><i class="fa-solid fa-fire" aria-hidden="true"></i> KRYTYCZNY</span>
                            </td>
                            <td>
                                <span class="badge-amber"><i class="fa-solid fa-clock" aria-hidden="true"></i> W trakcie</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span class="user-pill__avatar" style="width: 24px; height: 24px; font-size: 0.7rem;"><i class="fa-solid fa-user"></i></span>
                                    <span>Piotr Kowalski</span>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="/tickets/1" class="btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">
                                    Szczegóły <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="/tickets/2" class="font-mono" style="font-weight: 700; color: var(--clr-blue);">
                                    #WO-2024-8839
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Winda Osobowa KONE B3</div>
                                <span class="font-mono" style="font-size: 0.75rem; color: var(--clr-text-muted);">ELEV-8832-K3</span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Błąd czujnika krańcowego drzwi</div>
                                <span style="font-size: 0.75rem; color: var(--clr-text-muted);">Brak reakcji na piętrze 4</span>
                            </td>
                            <td>
                                <span class="badge-amber"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> WYSOKI</span>
                            </td>
                            <td>
                                <span class="badge-blue"><i class="fa-solid fa-envelope-open" aria-hidden="true"></i> Otwarte</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span class="user-pill__avatar" style="width: 24px; height: 24px; font-size: 0.7rem;"><i class="fa-solid fa-user"></i></span>
                                    <span>Piotr Kowalski</span>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="/tickets/2" class="btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">
                                    Szczegóły <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="/tickets/3" class="font-mono" style="font-weight: 700; color: var(--clr-blue);">
                                    #WO-2024-8835
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Agregat Chłodniczy Carrier 30XA</div>
                                <span class="font-mono" style="font-size: 0.75rem; color: var(--clr-text-muted);">HVAC-CAR-011</span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">Wyciek czynnika chłodniczego</div>
                                <span style="font-size: 0.75rem; color: var(--clr-text-muted);">Wymiana uszczelnień i napełnienie</span>
                            </td>
                            <td>
                                <span class="badge-blue"><i class="fa-solid fa-circle-info" aria-hidden="true"></i> NORMALNY</span>
                            </td>
                            <td>
                                <span class="badge-green"><i class="fa-solid fa-check" aria-hidden="true"></i> Rozwiązane</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span class="user-pill__avatar" style="width: 24px; height: 24px; font-size: 0.7rem;"><i class="fa-solid fa-user"></i></span>
                                    <span>Janusz Kamiński</span>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="/tickets/3" class="btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">
                                    Szczegóły <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
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
