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

    <main class="container error-page-container">
        <div class="card-block error-box">
            <div class="error-badge-icon">
                <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
            </div>
            <h1 class="text-2xl font-extrabold mb-sm">404</h1>
            <h2 class="text-lg font-bold mb-md">Nie znaleziono strony</h2>
            <p class="text-muted text-base mb-lg">
                Żądany zasób lub zlecenie nie istnieje w systemie AssetFix AI albo został przeniesiony do archiwum.
            </p>
            <a href="/" class="btn-primary btn-full">
                <i class="fa-solid fa-house" aria-hidden="true"></i> Wróć do pulpitu głównego
            </a>
        </div>
    </main>
</body>
</html>
