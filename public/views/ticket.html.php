<?php

declare(strict_types=1);

$ticketId = $ticket->id;
$statusValue = $ticket->status->value;
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
        <div class="flex-between mb-lg">
            <a href="/tickets" class="btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Wróć do rejestru zleceń
            </a>
            <div class="flex-row">
                <button type="button" class="btn-secondary btn-sm" onclick="window.print()">
                    <i class="fa-solid fa-print" aria-hidden="true"></i> Drukuj protokół
                </button>
            </div>
        </div>

        <div class="detail-layout">
            <div class="detail-main">
                <article class="card-block">
                    <div class="flex-between mb-md">
                        <div>
                            <span class="task-id">Zlecenie serwisowe #WO-<?= $ticketId ?></span>
                            <h1 class="text-xl font-extrabold">
                                <?= htmlspecialchars($ticket->title) ?>
                            </h1>
                            <div class="mt-xs">
                                <a href="/assets/<?= $ticket->assetId ?>" class="text-xs text-blue font-semibold">
                                    <i class="fa-solid fa-passport"></i> Otwórz paszport techniczny maszyny: <?= htmlspecialchars($ticket->assetName) ?> &rarr;
                                </a>
                            </div>
                        </div>
                        <div>
                            <span class="<?= $ticket->status->badgeClass() ?>"><i class="fa-solid <?= $ticket->status->iconClass() ?>"></i> <?= htmlspecialchars($ticket->status->label()) ?></span>
                        </div>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Numer seryjny maszyny</div>
                            <div class="meta-value font-mono"><?= htmlspecialchars($ticket->assetSerialNumber) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Data i czas zgłoszenia</div>
                            <div class="meta-value"><?= htmlspecialchars(substr($ticket->createdAt, 0, 16)) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Poziom SLA / Priorytet</div>
                            <div class="meta-value text-red"><i class="fa-solid fa-fire"></i> <?= htmlspecialchars($ticket->priority->slaLabel()) ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Przypisany technik</div>
                            <div class="meta-value"><?= htmlspecialchars($ticket->technicianName) ?></div>
                        </div>
                    </div>

                    <div class="mt-md">
                        <h2 class="text-sm font-bold text-muted">
                            <i class="fa-solid fa-align-left" aria-hidden="true"></i> Opis usterki wprowadzony przez operatora
                        </h2>
                        <div class="description-box">
                            <?= htmlspecialchars($ticket->description) ?>
                        </div>
                    </div>
                </article>

                <section class="card-block">
                    <h2><i class="fa-solid fa-sliders" aria-hidden="true"></i> Aktualizacja statusu przez serwisanta</h2>
                    <form action="/tickets/<?= $ticketId ?>" method="POST">
                        <div class="form-group">
                            <label for="status">Zmień bieżący status zlecenia:</label>
                            <select id="status" name="status" class="form-select">
                                <option value="OPEN" <?= $statusValue === 'OPEN' ? 'selected' : '' ?>>Otwarte (Oczekuje na podjęcie)</option>
                                <option value="IN_PROGRESS" <?= $statusValue === 'IN_PROGRESS' ? 'selected' : '' ?>>W trakcie naprawy</option>
                                <option value="RESOLVED" <?= $statusValue === 'RESOLVED' ? 'selected' : '' ?>>Rozwiązane (Zakończono serwis)</option>
                                <option value="CLOSED" <?= $statusValue === 'CLOSED' ? 'selected' : '' ?>>Zamknięte</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notatka serwisowa / podsumowanie podjętych czynności:</label>
                            <textarea id="notes" name="notes" class="form-textarea" placeholder="Wprowadź wykonane czynności serwisowe, wymienione części lub uwagi..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Zapisz zmianę statusu
                        </button>
                    </form>
                </section>

                <section class="card-block">
                    <h2><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i> Historia zmian statusu (<?= count($history) ?>)</h2>
                    <?php if (empty($history)): ?>
                        <p class="text-muted text-sm">Brak wpisów w historii.</p>
                    <?php else: ?>
                        <ul class="asset-meta-list">
                            <?php foreach ($history as $entry): ?>
                                <li class="flex-between">
                                    <div>
                                        <strong><?= htmlspecialchars((string) $entry['new_status']) ?></strong>
                                        <?php if (!empty($entry['old_status'])): ?>
                                            <span class="text-muted text-xs">(z <?= htmlspecialchars((string) $entry['old_status']) ?>)</span>
                                        <?php endif; ?>
                                        <div class="text-muted text-xs">
                                            <?= htmlspecialchars((string) ($entry['note'] ?? '')) ?>
                                            • <?= htmlspecialchars(trim((string) ($entry['changed_by_name'] ?? '')) ?: 'System') ?>
                                        </div>
                                    </div>
                                    <span class="text-muted text-xs font-mono"><?= htmlspecialchars(substr((string) $entry['created_at'], 0, 16)) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>

                <section class="card-block">
                    <h2><i class="fa-solid fa-camera" aria-hidden="true"></i> Dokumentacja fotograficzna (<?= count($photos) ?>)</h2>
                    <?php if (!empty($photos)): ?>
                        <ul class="asset-meta-list mb-md">
                            <?php foreach ($photos as $photo): ?>
                                <li class="flex-between">
                                    <span>
                                        <i class="fa-regular fa-image" aria-hidden="true"></i>
                                        <strong><?= htmlspecialchars((string) $photo['original_name']) ?></strong>
                                        <span class="text-muted text-xs">(<?= htmlspecialchars((string) $photo['mime_type']) ?>, <?= number_format((int) $photo['size_bytes'] / 1024, 1) ?> KB)</span>
                                    </span>
                                    <span class="text-muted text-xs"><?= htmlspecialchars(trim((string) ($photo['uploaded_by_name'] ?? '')) ?: 'Technik') ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="upload-dropzone">
                        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        <p class="font-semibold text-sm">Przeciągnij i upuść pliki lub kliknij poniżej</p>
                        <input type="file" id="ticket-photos" name="photos[]" multiple accept="image/jpeg,image/png,image/webp" class="mt-sm">
                    </div>
                </section>
            </div>

            <aside class="detail-sidebar">
                <div class="ai-diagnosis-widget mb-lg">
                    <div class="ai-widget-header">
                        <div class="ai-widget-brand">
                            <span class="ai-widget-icon"><i class="fa-solid fa-brain" aria-hidden="true"></i></span>
                            <div>
                                <div class="ai-widget-title">Smart Diagnosis AI</div>
                                <div class="ai-widget-subtitle">Moduł Ollama (Lokalny LLM)</div>
                            </div>
                        </div>
                        <span class="ai-badge">Analiza AI</span>
                    </div>

                    <div class="ai-suggestion-box">
                        <strong><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Wygenerowana rekomendacja:</strong>
                        <p><?= htmlspecialchars($ticket->aiSuggestion ?? 'Brak wygenerowanej diagnozy AI dla tego zgłoszenia.') ?></p>
                    </div>

                    <div class="text-muted text-xs">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        Sugestia zapisana w bazie PostgreSQL na podstawie analizy objawów i historii awarii.
                    </div>
                </div>

                <div class="card-block">
                    <h2><i class="fa-solid fa-industry" aria-hidden="true"></i> Karta maszyny</h2>
                    <div class="asset-meta-list">
                        <div class="flex-between">
                            <span class="text-muted">Nazwa:</span>
                            <strong><?= htmlspecialchars($ticket->assetName) ?></strong>
                        </div>
                        <div class="flex-between">
                            <span class="text-muted">Numer seryjny:</span>
                            <span class="font-mono"><?= htmlspecialchars($ticket->assetSerialNumber) ?></span>
                        </div>
                        <div class="flex-between">
                            <span class="text-muted">Klient / Miasto:</span>
                            <span><?= htmlspecialchars($ticket->clientName) ?> (<?= htmlspecialchars($ticket->clientCity) ?>)</span>
                        </div>
                        <div class="flex-between">
                            <span class="text-muted">Kategoria:</span>
                            <span><?= htmlspecialchars($ticket->categoryName) ?></span>
                        </div>
                    </div>
                    <div class="mt-md pt-md border-top">
                        <a href="/assets/<?= $ticket->assetId ?>" class="btn-secondary btn-full">
                            <i class="fa-solid fa-circle-nodes" aria-hidden="true"></i> Otwórz w EAM maszyn
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
