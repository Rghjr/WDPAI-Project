<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">Pulpit</a> | <a href="/tickets/add">Dodaj zgłoszenie</a>
        </nav>
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
    </header>

    <main class="container">
        <section>
            <p>Liczba otwartych zgłoszeń: <strong><?= htmlspecialchars((string) $openTicketsCount) ?></strong></p>
            <ul>
                <li>
                    <a href="/tickets/1">#1 – Turbina Wiatrowa V90 #04 (Spadek ciśnienia oleju)</a>
                </li>
                <li>
                    <a href="/tickets/2">#2 – Winda Osobowa KONE B3 (Błąd czujnika drzwi)</a>
                </li>
                <li>
                    <a href="/tickets/3">#3 – Agregat Chłodniczy Carrier (Wyciek czynnika)</a>
                </li>
            </ul>
        </section>
    </main>

    <footer>
        <p>AssetFix AI System</p>
    </footer>
</body>
</html>