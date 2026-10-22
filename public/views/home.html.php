<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <header>
        <h1>AssetFix AI – Panel Zarządzania Flotą i Awariami</h1>
        <nav>
            <ul>
                <li><a href="/tickets">Zgłoszenia Awarii</a></li>
                <li><a href="/tickets/add">Zgłoś Awarię</a></li>
                <li><a href="/assets">Baza Urządzeń (EAM)</a></li>
                <li><a href="/login">Logowanie</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Status Systemu</h2>
            <p>Wszystkie usługi kontenerowe uruchomione poprawnie (Nginx, PHP 8.3, PostgreSQL, Ollama AI, Mailpit)[cite: 3].</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 AssetFix AI System</p>
    </footer>
</body>
</html>