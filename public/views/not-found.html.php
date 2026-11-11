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

    <main class="container" style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">
        <div class="card-block" style="text-align: center; max-width: 500px; padding: 48px 32px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--clr-bg-red); color: var(--clr-red); display: grid; place-items: center; font-size: 1.8rem; margin: 0 auto 20px;">
                <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
            </div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 8px;">404</h1>
            <h2 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 12px; justify-content: center;">Nie znaleziono strony</h2>
            <p style="color: var(--clr-text-muted); font-size: 0.95rem; margin-bottom: 24px; line-height: 1.5;">
                Żądany zasób lub zlecenie nie istnieje w systemie AssetFix AI albo został przeniesiony do archiwum.
            </p>
            <a href="/" class="btn-primary" style="justify-content: center; width: 100%;">
                <i class="fa-solid fa-house" aria-hidden="true"></i> Wróć do pulpitu głównego
            </a>
        </div>
    </main>
</body>
</html>
