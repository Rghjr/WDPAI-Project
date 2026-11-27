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
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold">Projekty</h1>
                <p class="greeting-subtitle">Lista prowadzonych projektów serwisowych.</p>
            </div>
            <a class="btn-primary" href="/projects/add">Dodaj projekt</a>
        </header>
        <section class="data-table-container" aria-labelledby="projects-heading">
            <h2 id="projects-heading" class="sr-only">Lista projektów</h2>
            <div class="table-responsive">
                <table class="data-table">
                    <thead><tr><th scope="col">ID</th><th scope="col">Tytuł</th><th scope="col">Status</th><th scope="col">Utworzono</th></tr></thead>
                    <tbody>
                    <?php if ($projects === []): ?>
                        <tr><td colspan="4" class="text-muted">Brak projektów do wyświetlenia.</td></tr>
                    <?php else: ?>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td class="font-mono">#<?= $project->id ?></td>
                                <td><a class="font-bold text-blue" href="/projects/<?= $project->id ?>"><?= htmlspecialchars($project->title) ?></a></td>
                                <td><?= htmlspecialchars($project->status) ?></td>
                                <td><?= htmlspecialchars($project->createdAt) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
