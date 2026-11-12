# Stan projektu — inwentaryzacja

**Data:** 2026-10-27
**Branch:** `main` (commit `2b1069f`, Merge pull request #9)
**Kryteria oceny, których dotyczy:** wszystkie — punkt odniesienia dla dalszej pracy

## 1. Co jest w repozytorium

### 1.1 Pliki konfiguracyjne (root)

| Plik | Stan | Uwagi |
|---|---|---|
| `README.md` | gotowy szkic | Opis AssetFix AI, tabela funkcji, tech stack, szybki start, struktura, autorzy. Brakuje sekcji wymaganych przez kryterium 1 (zrzuty, ERD, przepływ, testy, deploy, konta demo, Security Bingo, WCAG). |
| `composer.json` | gotowy | Tylko autoload PSR-4: `App\` → `src/`, `App\Controller\` → `src/controllers/`. Brak zależności (PHPMailer, PHPUnit). |
| `docker-compose.yaml` | gotowy | 6 usług, 1 sieć, 2 wolumeny — szczegóły w 1.2. |
| `.env.example` | gotowy | `APP_PORT`, `POSTGRES_PORT`, `POSTGRES_DB`, `POSTGRES_USER`, `POSTGRES_PASSWORD`, `PGADMIN_CONTAINER_NAME`, `PGADMIN_DEFAULT_EMAIL`, `PGADMIN_DEFAULT_PASSWORD`, `MAILPIT_PORT`. Brak `PGADMIN_PORT` (używany w compose z domyślną 5050). |
| `.gitignore` | gotowy | `.env`, `.idea/`, `.vscode/`, `.DS_Store`, `vendor/`, `node_modules/`, `docker/data/`, `.vs/`. Od 2026-10-27 także `AGENTS.md`, `docs/`, `uploads/`, `var/`, `*.log`. |
| `.env` | lokalny | Istnieje lokalnie, poprawnie ignorowany. |
| `.vs/` | lokalny | Artefakty Visual Studio, ignorowane. |

### 1.2 Docker

| Usługa | Obraz / build | Porty | Rola |
|---|---|---|---|
| `server` | `docker/nginx/Dockerfile` (nginx:stable-alpine) | `${APP_PORT:-8080}:80` | Serwuje `/app/public`, `try_files` → `index.php`, FastCGI do `php:9000`, blokuje pliki `/.*`. |
| `php` | `docker/php/Dockerfile` (php:8.3-fpm-alpine) | — | Rozszerzenia: opcache, zip, gd, bcmath, pgsql, pdo_pgsql. Composer 2 skopiowany do obrazu. `upload_max_filesize=512M`. |
| `db` | `docker/db/Dockerfile` (postgres:16-alpine) | `${POSTGRES_PORT:-5433}:5432` | Wolumen `pg-data`; `./docker/db` zamontowany jako `/docker-entrypoint-initdb.d` (tam trafią pliki `.sql`). |
| `ollama` | ollama/ollama:latest | `11434:11434` | Lokalny LLM, wolumen `ollama_data`. Nieużywany jeszcze przez kod. |
| `mailpit` | axllent/mailpit:latest | `${MAILPIT_PORT:-8025}:8025` | Podgląd e-maili dev. Port SMTP 1025 nieopublikowany na host (wystarczy w sieci wewnętrznej). |
| `pgadmin-wdpai` | dpage/pgadmin4:latest | `${PGADMIN_PORT:-5050}:80` | Administracja bazą. |

Sieć: `pg-network` (wszystkie usługi). Wolumeny: `pg-data`, `ollama_data`.

### 1.3 Backend PHP (`src/`)

| Plik | Co robi |
|---|---|
| `Routing.php` | Klasa `final App\Routing`. Metody `get()`, `post()`, `dispatch(method, uri)`. Ścieżka `{id}` zamieniana na `(?P<id>\d+)` — parametr trafia do akcji jako `int`. Zwraca `false` gdy brak dopasowania. Sprawdza, że kontroler dziedziczy po `AppController`. |
| `controllers/AppController.php` | Abstrakcyjna baza. `render(template, variables)` — `extract()` + `require public/views/<template>.html.php`. Rzuca `RuntimeException` gdy brak widoku. |
| `controllers/DefaultController.php` | `index()` → widok `home`; `notFound()` → widok `not-found`. |
| `controllers/TicketController.php` | `index()` → `tickets` (hardkodowane `openTicketsCount=3`); `show(int $id)` → `ticket` (hardkodowane dane awarii turbiny + sugestia AI); `add()` → `add-ticket`. |
| `controllers/AssetController.php` | `index()` → `assets` (`totalAssets=12`); `login()` → `login`. |
| `controllers/ProjectController.php` | `index()` → `projects`, `show(int $id)` → `project`. **Pozostałość z ćwiczenia laboratoryjnego — nie jest zarejestrowany w `index.php`.** |

### 1.4 Front controller (`public/index.php`)

Zarejestrowane trasy (wszystkie GET):

| Trasa | Kontroler → akcja |
|---|---|
| `/` | `DefaultController::index` |
| `/tickets` | `TicketController::index` |
| `/tickets/add` | `TicketController::add` |
| `/tickets/{id}` | `TicketController::show` |
| `/assets` | `AssetController::index` |
| `/login` | `AssetController::login` |

Brak dopasowania → `http_response_code(404)` + `DefaultController::notFound()`.

Brak jakiejkolwiek trasy POST — formularze w widokach (`/login`, `/tickets/add`, `/tickets/{id}`) wysyłają POST, który kończy się 404.

### 1.5 Widoki (`public/views/`)

| Widok | Opis | Stan |
|---|---|---|
| `home.html.php` | Pulpit technika (mobile-first, wg Figmy): nagłówek, powitanie, 3 karty statystyk, 3 szybkie akcje, lista zleceń. | Statyczny HTML, dane zahardkodowane. Zawiera style inline i Google Fonts. Nie korzysta z `$pageTitle`. |
| `tickets.html.php` | Lista 3 zgłoszeń z linkami do `/tickets/{id}`. | Statyczna lista. |
| `ticket.html.php` | Szczegóły zgłoszenia: urządzenie, S/N, status, opis, sugestia AI, formularz zmiany statusu (POST). | Dane z kontrolera, dobra semantyka (`article`, `aside`, `time`, `mark`). |
| `add-ticket.html.php` | Formularz nowego zgłoszenia (`asset_id`, `title`, `description`). | POST bez obsługi. |
| `assets.html.php` | Tabela 2 maszyn. | Statyczna. |
| `login.html.php` | Formularz e-mail + hasło. | POST bez obsługi. |
| `not-found.html.php` | Strona 404. | OK. |
| `projects.html.php`, `project.html.php` | Pozostałość z laboratorium. | Nieużywane, do usunięcia. |

Każdy widok ma własny pełny `<html>` — nagłówek, nawigacja i stopka są powielone (sprzeczne z kryteriami 9 i 28). Nawigacja różni się między widokami.

### 1.6 CSS (`public/css/style.css`)

Design tokens w `:root` (kolory, promienie, font Inter), reset, layout `.app-container` (max 440px, mobile-first), grid na statystyki i akcje, karty zleceń, stany `:hover`/`:focus-visible`, jeden breakpoint `@media (min-width: 600px)`. Style dotyczą głównie `home`; pozostałe widoki używają klasy `.container`, która **nie jest zdefiniowana**.

### 1.7 Git

- Remote: `https://github.com/Rghjr/WDPAI-Project.git`, domyślny branch `main`.
- 26 commitów, 9 PR-ów scalonych przez merge commit (bez squash). Branche: `feature/home-page`, `docs/not-ready-readme`, `feature/docker-setup`, `feat/routing`, `feature/assetfix-controllers`, `feature/assetfix-views`, `chore/composer-autoload`, `feature/styles-and-responsive-design`, `feat/mobile-dashboard`, `docs/readme-update`.
- Komunikaty przeważnie zgodne z konwencją (`feat:`, `chore:`, `docs:`, `style:`). Wyjątek: `9a879e1 docs/not-ready-readme` (nazwa brancha zamiast komunikatu).
- Working tree czyste.

## 2. Jak to działa dziś (przepływ żądania)

```
przeglądarka → Nginx (:8080) → try_files → /app/public/index.php
    → App\Routing::dispatch(METHOD, URI)
    → new <Controller>() → <akcja>(...$params)
    → AppController::render('<widok>', [...]) → public/views/<widok>.html.php
```

Brak warstwy danych — każda akcja zwraca dane zahardkodowane w kontrolerze lub w widoku.

## 3. Znane problemy i braki (stan na dziś)

### Blokujące uruchomienie
1. **Brak `vendor/autoload.php`.** `index.php` wymaga autoloadera Composera, `vendor/` jest ignorowany, a `docker/php/Dockerfile` nie uruchamia `composer install` (dodatkowo wolumen `.:/app` nadpisuje zawartość obrazu). Na czystym środowisku aplikacja zwraca fatal error do czasu ręcznego `docker compose exec php composer install`. Do naprawy: `composer install` w Dockerfile lub w entrypoint, albo instrukcja w README.

### Względem kryteriów oceny
2. Brak PostgreSQL w kodzie — żadnego PDO, repozytorium, schematu, pliku `.sql` (kryteria 10, 11, 12, 25, 26).
3. Brak logowania, sesji, ról, uprawnień, wylogowania (20–24).
4. Brak tras POST i walidacji — formularze nie działają (4, 8, 15).
5. Brak JS i Fetch API (14, 15).
6. Brak partiali — nagłówek/nawigacja/stopka powielone (9, 28).
7. Brak dark/light mode (18), tłumaczeń (30), testów (31), CRON (32), PHPMailer (33), uploadu (34), deployu (36).
8. README nie ma zrzutów, ERD, przepływu, Security Bingo, raportu WCAG, kont demo, linku do deployu (1, 6, 19, 27).
9. `ProjectController` i widoki `projects`/`project` — martwy kod (29).
10. Style inline w `home.html.php`, niezdefiniowana klasa `.container` (16).
11. `.env.example` nie zawiera `PGADMIN_PORT`.
12. Nazwa pliku ini w PHP Dockerfile: `mealplanner.ini` — pozostałość z szablonu, kosmetyczne.

## 4. Co jest już dobre i warto zachować

- Działający autorski router z regexem i parametrem `{id}` typowanym na `int` — baza pod kryterium 4.
- Czysty podział kontroler → widok przez `AppController::render()`.
- `declare(strict_types=1)`, klasy `final`, typy — zgodne z kryteriami 5 i 13.
- Kompletny stos Docker: PHP-FPM z `pdo_pgsql`, PostgreSQL 16 z wolumenem, Mailpit, pgAdmin, Ollama.
- Poprawny `.gitignore`, `.env.example`, sekrety poza repozytorium.
- Historia Git: małe commity, PR-y, merge commity — dokładnie tak, jak wymaga prowadzący.
- Semantyczny HTML w `ticket.html.php`, tokeny CSS w `:root`.

## 5. Następny krok

Plan prac i backlog: [`plan-i-backlog.md`](plan-i-backlog.md). Pierwsze zadania: naprawa `composer install` w Dockerze, schemat bazy + `.sql`, warstwa repozytoriów, partiale widoków.
