<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <main class="container">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <form action="/login" method="POST">
            <div>
                <label for="email">E-mail służbowy:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Zaloguj się</button>
        </form>
    </main>
</body>
</html>