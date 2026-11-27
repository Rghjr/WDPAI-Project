<?php

declare(strict_types=1);

$totalUsers = (int) ($stats['total'] ?? 0);
$activeTechs = (int) ($stats['active_technicians'] ?? 0);
$activeAdmins = (int) ($stats['active_admins'] ?? 0);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) $pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1c520e4603.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require __DIR__ . '/partials/navigation.html.php'; ?>

    <main class="container">
        <header class="dashboard-header mb-lg">
            <div>
                <h1 class="text-xl font-extrabold flex-row">
                    <i class="fa-solid fa-users-gear text-blue" aria-hidden="true"></i>
                    Zespół Techniczny i Uprawnienia
                </h1>
                <p class="greeting-subtitle">
                    Ewidencja użytkowników systemu, ról (ADMIN / TECHNICIAN) oraz aktywnych zleceń z bazy PostgreSQL
                </p>
            </div>
            <div class="flex-row flex-wrap gap-sm">
                <span class="meta-pill">Łącznie kont: <strong class="text-blue"><?= $totalUsers ?></strong></span>
            </div>
        </header>

        <section class="stats-grid mb-lg" aria-label="Wskaźniki zespołu">
            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Aktywni technicy</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-truck-fast"></i></span>
                </div>
                <div class="stat-card__value text-blue"><?= $activeTechs ?></div>
                <div class="stat-card__desc text-green"><i class="fa-solid fa-circle text-xs"></i> Rola TECHNICIAN</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Menedżerowie / Dyspozytorzy</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-user-shield"></i></span>
                </div>
                <div class="stat-card__value text-green"><?= $activeAdmins ?></div>
                <div class="stat-card__desc text-muted"><i class="fa-solid fa-shield-check"></i> Rola ADMIN</div>
            </div>

            <div class="stat-card">
                <div class="stat-card__top">
                    <span class="stat-card__title">Wszystkie konta w bazie</span>
                    <span class="stat-card__icon"><i class="fa-solid fa-users"></i></span>
                </div>
                <div class="stat-card__value"><?= $totalUsers ?></div>
                <div class="stat-card__desc text-muted">Dane pobierane z PostgreSQL</div>
            </div>
        </section>

        <section class="data-table-container">
            <div class="table-responsive">
                <table class="data-table" aria-label="Tabela pracowników serwisu">
                    <thead>
                        <tr>
                            <th scope="col">Specjalista UR</th>
                            <th scope="col">Rola Systemowa</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Rejon Operacyjny</th>
                            <th scope="col">Status Konta</th>
                            <th scope="col">Otwarte Zlecenia</th>
                            <th scope="col" class="text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $member): ?>
                            <?php
                            $isAdmin = $member['role_name'] === 'ADMIN';
                            $isActive = (bool) $member['is_active'];
                            ?>
                            <tr>
                                <td>
                                    <div class="flex-row">
                                        <div class="avatar-circle">
                                            <i class="fa-solid <?= $isAdmin ? 'fa-user-shield' : 'fa-user-gear' ?>"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm"><?= htmlspecialchars((string) $member['first_name'] . ' ' . $member['last_name']) ?></div>
                                            <div class="text-xs text-muted font-mono"><?= htmlspecialchars((string) ($member['employee_code'] ?? '—')) ?> • <?= htmlspecialchars((string) $member['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="<?= $isAdmin ? 'badge-red' : 'badge-blue' ?> font-bold">
                                        <?= htmlspecialchars((string) $member['role_name']) ?>
                                    </span>
                                </td>
                                <td class="font-mono text-xs"><?= htmlspecialchars((string) ($member['phone'] ?? '—')) ?></td>
                                <td><?= htmlspecialchars((string) ($member['base_location'] ?? '—')) ?></td>
                                <td>
                                    <?php if ($isActive): ?>
                                        <span class="badge-green"><i class="fa-solid fa-circle-check"></i> AKTYWNY</span>
                                    <?php else: ?>
                                        <span class="badge-amber"><i class="fa-solid fa-pause"></i> NIEAKTYWNY</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="font-bold"><?= (int) ($member['open_tickets_count'] ?? 0) ?></span>
                                </td>
                                <td class="text-right">
                                    <a href="/profile" class="btn-secondary btn-sm"><i class="fa-solid fa-id-card"></i> Karta</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
