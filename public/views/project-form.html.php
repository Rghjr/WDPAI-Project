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
        <div class="form-card">
            <header class="form-header">
                <a href="<?= $projectId === null ? '/projects' : '/projects/' . $projectId ?>" class="btn-secondary btn-sm">← Wróć</a>
                <h1><?= htmlspecialchars((string) $pageTitle) ?></h1>
            </header>
            <form action="<?= htmlspecialchars((string) $formAction) ?>" method="POST" novalidate>
                <div class="form-group">
                    <label for="title">Tytuł projektu</label>
                    <input class="form-input" type="text" id="title" name="title" maxlength="180" required value="<?= htmlspecialchars($project['title']) ?>" aria-invalid="<?= isset($errors['title']) ? 'true' : 'false' ?>" aria-describedby="<?= isset($errors['title']) ? 'title-error' : '' ?>">
                    <?php if (isset($errors['title'])): ?><p id="title-error" class="text-red" role="alert"><?= htmlspecialchars($errors['title']) ?></p><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea class="form-textarea" id="description" name="description" rows="6"><?= htmlspecialchars((string) $project['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-select" id="status" name="status" required aria-invalid="<?= isset($errors['status']) ? 'true' : 'false' ?>">
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= htmlspecialchars($status) ?>" <?= $project['status'] === $status ? 'selected' : '' ?>><?= htmlspecialchars($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['status'])): ?><p class="text-red" role="alert"><?= htmlspecialchars($errors['status']) ?></p><?php endif; ?>
                </div>
                <div class="form-actions">
                    <a href="<?= $projectId === null ? '/projects' : '/projects/' . $projectId ?>" class="btn-secondary">Anuluj</a>
                    <button class="btn-primary" type="submit">Zapisz projekt</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
