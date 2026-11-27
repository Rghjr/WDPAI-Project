<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) $pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>
    <main class="container">
        <a class="btn-secondary" href="/projects">← Wróć do projektów</a>
        <article class="data-table-container mt-lg">
            <header>
                <p class="text-muted font-mono">PROJEKT #<?= $project->id ?></p>
                <h1 class="text-xl font-extrabold"><?= htmlspecialchars($project->title) ?></h1>
            </header>
            <dl>
                <dt>Status</dt><dd><?= htmlspecialchars($project->status) ?></dd>
                <dt>Utworzono</dt><dd><?= htmlspecialchars($project->createdAt) ?></dd>
                <dt>Ostatnia aktualizacja</dt><dd><?= htmlspecialchars($project->updatedAt) ?></dd>
                <dt>Opis</dt><dd><?= nl2br(htmlspecialchars($project->description ?? 'Brak opisu.')) ?></dd>
            </dl>
        </article>
    </main>
</body>
</html>
