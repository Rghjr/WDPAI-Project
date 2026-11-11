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
                <h1>
                    <i class="fa-solid fa-triangle-exclamation text-red" aria-hidden="true"></i>
                    <?= htmlspecialchars($pageTitle) ?>
                </h1>
                <p>
                    Wypełnij formularz awarii. Dane zostaną natychmiast przekazane do analizy silnikowi <strong>Ollama Smart Diagnosis AI</strong>.
                </p>
            </header>

            <form action="/tickets/add" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="asset_id">Wybierz urządzenie / maszynę z bazy:</label>
                    <select id="asset_id" name="asset_id" class="form-select" required>
                        <option value="">-- Wybierz maszynę z rejestru EAM --</option>
                        <option value="1">#1 – Turbina Wiatrowa V90 #04 (Margonin • S/N: TURB-2024-9004)</option>
                        <option value="2">#2 – Winda Osobowa KONE B3 (Biurowiec Pixel • S/N: ELEV-8832-K3)</option>
                        <option value="3">#3 – Sprężarka śrubowa Atlas Copco GA 75 (Solaris Bolechowo • S/N: COMP-AC-7599)</option>
                        <option value="4">#4 – Agregat Chłodniczy Carrier 30XA (Komorniki • S/N: HVAC-CAR-011)</option>
                    </select>
                    <span class="form-hint">Możesz też zeskanować kod QR na maszynie kamerą telefonu.</span>
                </div>

                <div class="form-group">
                    <label for="priority">Poziom pilności / SLA:</label>
                    <select id="priority" name="priority" class="form-select" required>
                        <option value="CRITICAL">Krytyczny (Zatrzymanie produkcji • Czas reakcji &lt; 2h)</option>
                        <option value="HIGH">Wysoki (Ograniczona wydajność • Czas reakcji &lt; 6h)</option>
                        <option value="NORMAL" selected>Standardowy (Usterka bieżąca • Czas reakcji &lt; 24h)</option>
                        <option value="LOW">Niski (Planowany przegląd lub drobna regulacja)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Tytuł zgłoszenia / krótki opis problemu:</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="np. Spadek ciśnienia oleju w przekładni, nietypowe wibracje" required>
                </div>

                <div class="form-group">
                    <label for="description">Szczegółowy opis objawów (dane dla modelu AI Ollama):</label>
                    <textarea id="description" name="description" class="form-textarea" rows="5" placeholder="Opisz objawy, kody błędów z falownika/sterownika PLC, odczyty wibracji i temperatury..." required></textarea>
                    <span class="form-hint">
                        <i class="fa-solid fa-brain text-ai"></i>
                        Im dokładniejszy opis parametrów, tym trafniejsze sugestie wygeneruje lokalny model Ollama.
                    </span>
                </div>

                <div class="form-group">
                    <label for="photo">Załącz zdjęcie uszkodzenia / tabliczki znamionowej (opcjonalnie):</label>
                    <input type="file" id="photo" name="photo" class="form-input" accept="image/jpeg,image/png,image/webp">
                    <span class="form-hint">Dopuszczalne formaty: JPG, PNG, WebP do 5MB.</span>
                </div>

                <div class="form-actions">
                    <a href="/tickets" class="btn-secondary">Anuluj</a>
                    <button type="submit" class="btn-ai">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Generuj diagnozę AI i Wyślij
                    </button>
                </div>
            </form>
        </div>

    </main>
</body>
</html>
