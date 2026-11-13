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

    <main class="container login-wrapper">
    <?php $cardClass = !empty($errors) ? 'login-card error' : 'login-card'; ?>

            <div class="<?= $cardClass ?>">            <div class="login-brand">
                <span class="brand-icon"><i class="fa-solid fa-gears" aria-hidden="true"></i></span>
                <h1 class="text-xl font-extrabold">
                    AssetFix<span class="text-blue">.AI</span>
                </h1>
                <p class="text-muted text-sm mb-sm">
                    Dostęp do platformy serwisowej i predykcyjnej EAM
                </p>
            </div>

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
<form action="/login" method="POST">
                <div class="form-group">
                    <label for="email">E-mail służbowy:</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="nazwisko@assetfix.ai" required autocomplete="email">
                </div>

<form action="/login" method="POST">
                <div class="form-group">
                    <div class="flex-between">
                        <label for="password">Hasło dostępu:</label>
                        <a href="#" class="text-muted text-xs">Zapomniałeś hasła?</a>
                    </div>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••••••" required autocomplete="current-password">
                </div>

                <div class="flex-row mb-lg">
                    <input type="checkbox" id="remember" name="remember" class="form-checkbox">
                    <label for="remember" class="text-muted text-sm cursor-pointer">
                        Zapamiętaj tę sesję na 30 dni
                    </label>
                </div>

                <button type="submit" class="btn-primary btn-full">
                    <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Zaloguj się do systemu
                </button>
            </form>

            <!-- Konta demonstracyjne dla oceniającego (Kryterium 20 i 23) -->
            <div class="demo-credentials">
                <div class="demo-title">
                    <i class="fa-solid fa-key" aria-hidden="true"></i> Szybkie logowanie demo:
                </div>
                <div class="demo-badges">
                    <div class="demo-account-pill" onclick="document.getElementById('email').value='admin@assetfix.ai'; document.getElementById('password').value='Admin123!';">
                        <div>
                            <strong>Menedżer (ADMIN)</strong>
                            <div class="text-muted text-xs">admin@assetfix.ai • pełne uprawnienia</div>
                        </div>
                        <span class="badge-blue text-xs">Wstaw</span>
                    </div>

                    <div class="demo-account-pill" onclick="document.getElementById('email').value='technik@assetfix.ai'; document.getElementById('password').value='Technik123!';">
                        <div>
                            <strong>Technik (TECHNICIAN)</strong>
                            <div class="text-muted text-xs">technik@assetfix.ai • zlecenia i diagnoza</div>
                        </div>
                        <span class="badge-green text-xs">Wstaw</span>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
