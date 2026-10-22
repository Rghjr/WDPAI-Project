<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <header>
        <nav>
            <a href="/">Pulpit</a> | <a href="/tickets">Zgłoszenia</a>
        </nav>
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
    </header>

    <main>
        <section>
            <p>Łącznie zarejestrowanych maszyn w bazie: <strong><?= htmlspecialchars((string) $totalAssets) ?></strong></p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa Urządzenia</th>
                        <th>Numer Seryjny</th>
                        <th>Kategoria</th>
                        <th>Ostatni Przegląd</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Turbina Wiatrowa V90 #04</td>
                        <td>TURB-2024-9004</td>
                        <td>OZE / Wiatr</td>
                        <td>2026-01-15</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Winda Osobowa KONE B3</td>
                        <td>ELEV-8832-K3</td>
                        <td>Dźwigi</td>
                        <td>2026-05-10</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>