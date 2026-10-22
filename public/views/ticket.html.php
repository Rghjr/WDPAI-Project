<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Pulpit</a></li>
                <li><a href="/tickets">Lista Zgłoszeń</a></li>
                <li><a href="/tickets/add">Nowe Zgłoszenie</a></li>
                <li><a href="/assets">Maszyny (EAM)</a></li>
                <li><a href="/login">Konto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <article>
            <header>
                <h1>Zgłoszenie #<?= htmlspecialchars((string) $ticketId) ?></h1>
                <p>Urządzenie: <strong><?= htmlspecialchars($assetName) ?></strong> (S/N: <?= htmlspecialchars($serialNumber) ?>)</p>
                <p>Status: <mark><?= htmlspecialchars($status) ?></mark></p>
                <p>Data zgłoszenia: <time datetime="<?= htmlspecialchars($createdAt) ?>"><?= htmlspecialchars($createdAt) ?></time></p>
            </header>

            <section>
                <h2>Opis usterki wprowadzony przez operatora</h2>
                <p><?= htmlspecialchars($description) ?></p>
            </section>

            <aside>
                <h2>Smart Diagnosis (Sugerowane rozwiązanie AI)</h2>
                <blockquote>
                    <p><?= htmlspecialchars($aiSuggestion) ?></p>
                </blockquote>
            </aside>

            <section>
                <h2>Aktualizacja statusu przez serwisanta</h2>
                <form action="/tickets/<?= htmlspecialchars((string) $ticketId) ?>" method="POST">
                    <div>
                        <label for="status">Zmień status:</label>
                        <select id="status" name="status">
                            <option value="otwarte">Otwarte</option>
                            <option value="w_trakcie" selected>W trakcie naprawy</option>
                            <option value="rozwiazane">Rozwiązane</option>
                        </select>
                    </div>
                    <button type="submit">Zapisz zmianę</button>
                </form>
            </section>
        </article>
    </main>

    <footer>
        <p>&copy; 2026 AssetFix AI – Enterprise Asset & Field Service Management System.</p>
    </footer>
</body>
</html>