<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>
    <main>
        <h1>Id przekazane przez URL, do kontrolera i na widok: <?= $projectId ?></h1>
    </main>
</body>
</html>
