<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssetFix Dashboard</title>
    <!-- Podpięcie zewnętrznego arkusza CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Opcjonalnie font, aby wyglądało to jeszcze lepiej -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="app-container">
        
        <!-- Nagłówek -->
        <header class="header">
            <div>
                <div class="logo-title">AssetFix.AI</div>
                <div class="logo-subtitle">Dashboard</div>
            </div>
            <div class="user-actions">
                <button aria-label="Powiadomienia" style="background:none;border:none;cursor:pointer;font-size:1.2rem;">🔔</button>
                <div class="avatar"></div>
            </div>
        </header>

        <!-- Powitanie -->
        <section class="greeting">
            <div class="greeting-row">
                <h1 class="greeting-title">Cześć,<br>Piotr! 👋</h1>
                <span class="badge-green">● Dostępny w terenie</span>
            </div>
            <p class="greeting-subtitle">Główny Technik Serwisu</p>
            <div class="status-cloud">☁️ Połączono (Baza Poznań-Cen sync: 2m temu)</div>
        </section>

        <!-- Statystyki -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Dzisiejsze zlecenia 📅</div>
                <div class="stat-value">5</div>
                <div class="stat-desc">3 zapl. • 1 w toku</div>
            </div>
            <div class="stat-card critical">
                <div class="stat-title text-red">Pilne / Awaria ⚠️</div>
                <div class="stat-value text-red">1 <span style="font-size:0.8rem">KRYTYCZNY</span></div>
                <div class="stat-desc text-red">SLA: natychmiast</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Ten tydzień ✅</div>
                <div class="stat-value">18</div>
                <div class="stat-desc text-green">● 98.4% SLA</div>
            </div>
        </section>

        <!-- Szybkie operacje -->
        <section class="quick-actions">
            <h2 class="section-title">Szybkie operacje <span style="font-size: 0.8rem; color: var(--clr-text-muted); font-weight: 500;">Gotowość do akcji</span></h2>
            <div class="actions-grid">
                <button class="action-btn blue">
                    <span style="font-size: 1.5rem;">⛶</span> Skanuj QR maszyny
                </button>
                <button class="action-btn red">
                    <span style="font-size: 1.5rem;">🚨</span> Zgłoś nagłą awarię
                </button>
                <button class="action-btn dark">
                    <span style="font-size: 1.5rem;">📍</span> Otwórz mapę tras
                </button>
            </div>
        </section>

        <!-- Lista Zleceń -->
        <section class="tasks">
            <h2 class="section-title">Przydzielone zlecenia na dziś <span class="badge-green" style="background:#f3f4f6;color:var(--clr-text-main);">3</span></h2>
            
            <div class="tasks-list">
                <!-- Zlecenie 1 -->
                <article class="task-card border-red">
                    <div class="task-header">
                        <span class="task-id">#WO-2024-8841</span>
                        <span class="badge-red">● KRYTYCZNY (SLA 2H)</span>
                    </div>
                    <h3 class="task-title">Awaria sprężarki śrubowej Atlas Copco GA 75 VSD+</h3>
                    <p class="task-location">🏢 Zakład Produkcyjny Solaris Bus & Coach, Bolechowo</p>
                    <div class="task-tags">
                        <span class="tag red-light">Wysoka wibracja łożyska</span>
                        <span class="tag gray-light">📍 4.2 km stąd</span>
                    </div>
                    <div class="task-footer">
                        <span class="task-time">🕒 08:30 - 10:30</span>
                        <button class="btn-primary">Rozpocznij</button>
                    </div>
                </article>
            </div>
        </section>

    </main>

</body>
</html>