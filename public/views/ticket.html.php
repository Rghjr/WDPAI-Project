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
        
        <!-- Pasek powrotu i akcji -->
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="/tickets" class="btn-secondary" style="padding: 8px 14px; font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Wróć do rejestru zleceń
            </a>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-secondary" style="padding: 8px 14px; font-size: 0.85rem;" onclick="window.print()">
                    <i class="fa-solid fa-print" aria-hidden="true"></i> Drukuj protokół
                </button>
            </div>
        </div>

        <!-- Układ szczegółów zlecenia -->
        <div class="detail-layout">
            
            <!-- Lewa kolumna: Szczegóły usterki, zmiana statusu i załączniki -->
            <div class="detail-main">
                
                <article class="card-block">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span class="task-id">Zlecenie serwisowe #<?= htmlspecialchars((string) $ticketId) ?></span>
                            <h1 style="font-size: 1.6rem; font-weight: 800; margin-top: 4px;">
                                <?= htmlspecialchars($assetName) ?>
                            </h1>
                        </div>
                        <div>
                            <?php if ($status === 'w_trakcie'): ?>
                                <span class="badge-amber" style="font-size: 0.85rem;"><i class="fa-solid fa-clock"></i> W TRAKCIE NAPRAWY</span>
                            <?php elseif ($status === 'rozwiazane'): ?>
                                <span class="badge-green" style="font-size: 0.85rem;"><i class="fa-solid fa-check"></i> ROZWIĄZANE</span>
                            <?php else: ?>
                                <span class="badge-blue" style="font-size: 0.85rem;"><i class="fa-solid fa-envelope-open"></i> OTWARTE</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Siatka metadanych -->
                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Numer seryjny maszyny</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($serialNumber) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Data i czas zgłoszenia</div>
                            <div class="meta-value"><?= htmlspecialchars($createdAt) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Poziom SLA / Priorytet</div>
                            <div class="meta-value text-red"><i class="fa-solid fa-fire"></i> KRYTYCZNY (2H)</div>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <h2 style="font-size: 1rem; font-weight: 700; color: var(--clr-text-muted); text-transform: uppercase; letter-spacing: 0.04em;">
                            <i class="fa-solid fa-align-left" aria-hidden="true"></i> Opis usterki wprowadzony przez operatora
                        </h2>
                        <div style="background: var(--clr-bg-card-subtle); padding: 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); line-height: 1.6; margin-top: 8px;">
                            <?= htmlspecialchars($description) ?>
                        </div>
                    </div>
                </article>

                <!-- Formularz aktualizacji statusu przez serwisanta -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-sliders" aria-hidden="true"></i> Aktualizacja statusu przez serwisanta</h2>
                    <form action="/tickets/<?= htmlspecialchars((string) $ticketId) ?>" method="POST">
                        <div class="form-group">
                            <label for="status">Zmień bieżący status zlecenia:</label>
                            <select id="status" name="status" class="form-select">
                                <option value="otwarte" <?= $status === 'otwarte' ? 'selected' : '' ?>>Otwarte (Oczekuje na podjęcie)</option>
                                <option value="w_trakcie" <?= $status === 'w_trakcie' ? 'selected' : '' ?>>W trakcie naprawy</option>
                                <option value="rozwiazane" <?= $status === 'rozwiazane' ? 'selected' : '' ?>>Rozwiązane (Zakończono serwis)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notatka serwisowa / podsumowanie podjętych czynności:</label>
                            <textarea id="notes" name="notes" class="form-textarea" placeholder="Wprowadź wykonane czynności serwisowe, wymienione części lub uwagi..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Zapisz zmianę statusu
                        </button>
                    </form>
                </section>

                <!-- Dokumentacja fotograficzna i załączniki -->
                <section class="card-block">
                    <h2><i class="fa-solid fa-camera" aria-hidden="true"></i> Dokumentacja fotograficzna usterki / naprawy</h2>
                    <p style="font-size: 0.85rem; color: var(--clr-text-muted); margin-bottom: 14px;">
                        Dodaj zdjęcia uszkodzonego elementu lub protokół zakończenia prac (obsługiwane: JPEG, PNG, WebP do 5MB).
                    </p>
                    <div style="border: 2px dashed var(--border-color); border-radius: var(--radius-md); padding: 24px; text-align: center; background: var(--clr-bg-card-subtle);">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; color: var(--clr-blue); margin-bottom: 8px;"></i>
                        <p style="font-weight: 600; font-size: 0.9rem;">Przeciągnij i upuść pliki lub kliknij poniżej</p>
                        <input type="file" id="ticket-photos" name="photos[]" multiple accept="image/jpeg,image/png,image/webp" style="margin-top: 10px;">
                    </div>
                </section>

            </div>

            <!-- Prawa kolumna: Smart Diagnosis AI & Informacje o zasobie -->
            <aside class="detail-sidebar">
                
                <!-- Widżet AI Smart Diagnosis -->
                <div class="ai-diagnosis-widget" style="margin-bottom: 20px;">
                    <div class="ai-widget-header">
                        <div class="ai-widget-brand">
                            <span class="ai-widget-icon"><i class="fa-solid fa-brain" aria-hidden="true"></i></span>
                            <div>
                                <div class="ai-widget-title">Smart Diagnosis AI</div>
                                <div class="ai-widget-subtitle">Moduł Ollama (Lokalny LLM)</div>
                            </div>
                        </div>
                        <span class="ai-badge">Analiza AI</span>
                    </div>

                    <div class="ai-suggestion-box">
                        <strong><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Wygenerowana rekomendacja:</strong>
                        <p><?= htmlspecialchars($aiSuggestion) ?></p>
                    </div>

                    <div style="font-size: 0.8rem; color: var(--clr-text-muted); line-height: 1.4;">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        Sugestia wygenerowana na podstawie danych telemetrii, historii poprzednich awarii tego modelu oraz analizy wektorowej.
                    </div>
                </div>

                <!-- Karta informacji o maszynie -->
                <div class="card-block">
                    <h2><i class="fa-solid fa-industry" aria-hidden="true"></i> Karta maszyny</h2>
                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.85rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--clr-text-muted);">Nazwa:</span>
                            <strong><?= htmlspecialchars($assetName) ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--clr-text-muted);">Numer seryjny:</span>
                            <span class="font-mono"><?= htmlspecialchars($serialNumber) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--clr-text-muted);">Lokalizacja:</span>
                            <span>Bolechowo (Hala Produkcyjna A)</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--clr-text-muted);">Kategoria:</span>
                            <span>Sprężarki i kompresory</span>
                        </div>
                    </div>
                    <div style="margin-top: 16px; pt-16; border-top: 1px solid var(--border-color); padding-top: 12px;">
                        <a href="/assets" class="btn-secondary" style="width: 100%; justify-content: center; font-size: 0.85rem;">
                            <i class="fa-solid fa-circle-nodes" aria-hidden="true"></i> Otwórz w EAM maszyn
                        </a>
                    </div>
                </div>

            </aside>

        </div>

    </main>
</body>
</html>
