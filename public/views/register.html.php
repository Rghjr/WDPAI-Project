<?php
declare(strict_types=1);
?>
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

    <main class="container register-wrapper">
    <?php $cardClass = !empty($errors) ? 'register-card error' : 'register-card'; ?>
    <div class="<?= $cardClass ?>">
            <h1 class="text-xl font-extrabold mb-md">Rejestracja</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success ?? null)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form action="/register" method="POST">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" class="form-input" required
                           value="<?= htmlspecialchars($data['username'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="email">E‑mail</label>
                    <input type="email" id="email" name="email" class="form-input" required
                           value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="confirm">Powtórz hasło</label>
                    <input type="password" id="confirm" name="confirm" class="form-input" required>
                </div>
                <button type="submit" class="btn-primary btn-full">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i> Zarejestruj się
                </button>
            </form>
        </div>
    </main>
</body>
</html>
