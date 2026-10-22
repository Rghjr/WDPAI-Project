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
            <a href="/tickets">Wróć do listy</a>
        </nav>
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
    </header>

    <main>
        <form action="/tickets/add" method="POST">
            <div>
                <label for="asset_id">ID Urządzenia / Maszyny:</label>
                <input type="number" id="asset_id" name="asset_id" required>
            </div>
            <div>
                <label for="title">Tytuł Zgłoszenia:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="description">Opis Usterki (dane dla Ollamy):</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>
            <button type="submit">Generuj diagnozę AI i Wyślij</button>
        </form>
    </main>
</body>
</html>