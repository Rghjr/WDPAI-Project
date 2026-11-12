# AGENTS.md — przewodnik dla agentów AI pracujących nad AssetFix AI

Ten plik jest instrukcją dla każdego agenta (Cursor, Copilot, Claude, inne), który modyfikuje to repozytorium.
Przeczytaj go w całości przed pierwszą zmianą. Zasady tutaj opisane mają pierwszeństwo przed domyślnymi nawykami agenta.

## 1. Czym jest ten projekt

**AssetFix AI** — projekt zaliczeniowy z przedmiotu *Wstęp do Projektowania Aplikacji Internetowych* (WDPAI, Politechnika Krakowska, prowadzący mgr inż. Adrian Widłak).

Aplikacja webowa w PHP dla firm serwisowych: menedżer zarządza zgłoszeniami awarii maszyn (ticketami) i parkiem maszynowym, technik odbiera zlecenia, aktualizuje ich status i dokumentuje naprawę. Opcjonalny moduł AI (Ollama) podpowiada przyczyny awarii na podstawie opisu.

Pełny opis założeń: [`README.md`](README.md). Aktualny stan i historia zmian: katalog [`docs/`](docs/).

Projekt jest **oceniany według 36 kryteriów** (lista w sekcji 8). Każda decyzja projektowa powinna przybliżać projekt do spełnienia kolejnych kryteriów, a nie oddalać od już spełnionych.

## 2. Stack i środowisko

| Warstwa | Technologia | Uwagi |
|---|---|---|
| Backend | PHP 8.3 (FPM, Alpine) | `declare(strict_types=1)` w każdym pliku, PSR-4 przez Composer |
| Serwer HTTP | Nginx | `docker/nginx/nginx.conf`, root `/app/public`, front controller `index.php` |
| Baza | PostgreSQL 16 | `docker/db/`, dane w wolumenie `pg-data`, init-skrypty `.sql` z `docker/db/` |
| Poczta (dev) | Mailpit | port `${MAILPIT_PORT:-8025}` |
| Admin bazy | pgAdmin 4 | port `${PGADMIN_PORT:-5050}` |
| AI | Ollama | port `11434`, wolumen `ollama_data` |
| Orkiestracja | Docker Compose | `docker-compose.yaml` |

Uruchomienie: `docker compose up --build -d`, aplikacja pod `http://localhost:${APP_PORT:-8080}`.

Zmienne środowiskowe: tylko przez `.env` (ignorowany przez Git). Szablon bez sekretów: `.env.example`. **Dodając nową zmienną, zawsze dopisz ją do `.env.example` z bezpieczną wartością przykładową.**

## 3. Struktura katalogów i gdzie co dodawać

```
my-app/
├── AGENTS.md              ← ten plik
├── README.md              ← dokumentacja dla oceniającego (kryterium 1)
├── docs/                  ← dziennik zmian i dokumentacja techniczna (sekcja 6)
├── composer.json          ← autoload PSR-4: App\ → src/, App\Controller\ → src/controllers/
├── docker-compose.yaml
├── docker/
│   ├── nginx/             ← Dockerfile + nginx.conf
│   ├── php/               ← Dockerfile (PHP 8.3 FPM + pdo_pgsql, gd, zip, opcache, bcmath)
│   └── db/                ← Dockerfile (postgres:16-alpine) + pliki .sql ładowane przy pierwszym starcie
├── public/                ← jedyny katalog widoczny z sieci
│   ├── index.php          ← front controller: rejestracja tras + dispatch
│   ├── css/               ← arkusze stylów (żadnych styli inline w widokach)
│   ├── js/                ← (do utworzenia) moduły JS, Fetch API
│   └── views/             ← szablony *.html.php
└── src/
    ├── Routing.php        ← autorski router (GET/POST, {id} → \d+)
    ├── controllers/       ← kontrolery dziedziczące po AppController
    ├── repository/        ← (do utworzenia) klasy dostępu do bazy (PDO, parametryzowane zapytania)
    ├── models/            ← (do utworzenia) obiekty domenowe
    └── services/          ← (do utworzenia) logika biznesowa (AI, mail, upload, auth)
```

Zasady rozmieszczania kodu:
- **Kontroler** tylko: odczyt żądania, wywołanie serwisu/repozytorium, wybór widoku. Zero SQL, zero HTML, zero logiki biznesowej.
- **Repozytorium** tylko: zapytania do PostgreSQL przez PDO, mapowanie wierszy na obiekty.
- **Serwis**: logika biznesowa, walidacja, integracje (Ollama, PHPMailer, upload).
- **Widok**: HTML + minimalne PHP (`<?= htmlspecialchars(...) ?>`, pętle, warunki). Powtarzalne fragmenty (nagłówek, nawigacja, stopka) wydziel do `public/views/partials/`.
- Każda nowa przestrzeń nazw musi być dopisana do `composer.json` (`autoload.psr-4`).

## 4. Konwencje kodu

### PHP
- `declare(strict_types=1);` na początku każdego pliku.
- Deklaracje typów parametrów, zwracanych wartości i właściwości — zawsze.
- Klasy `final`, chyba że są projektowane do dziedziczenia (np. `AppController`).
- Nazwy klas `PascalCase`, metod i zmiennych `camelCase`, stałe `UPPER_SNAKE`.
- Zapytania SQL **wyłącznie** parametryzowane (`prepare` + `bindValue`/`execute([...])`). Nigdy konkatenacja danych wejściowych.
- Wyjście do HTML **zawsze** przez `htmlspecialchars()` (lub helper `e()` gdy powstanie).
- Hasła tylko przez `password_hash()` / `password_verify()`.
- Błędne/nieistniejące `id` → kontrolowana odpowiedź 400/404, nigdy warning PHP.
- Brak `var_dump`, `print_r`, `die()` w kodzie commitowanym.

### HTML / CSS / JS
- HTML semantyczny (`header`, `nav`, `main`, `section`, `article`, `footer`); formularze z `<label for>`, poprawnymi `type`, komunikatami błędów.
- Style tylko w `public/css/`. Zmienne CSS w `:root`, motyw przez `html[data-theme="dark"]`.
- JS w `public/js/` jako moduły/funkcje. Fetch API zamiast przeładowań tam, gdzie to uzasadnione.
- Dostępność: widoczny focus, `alt` na obrazach, kontrast, obsługa klawiaturą.

### Język
- Interfejs i dokumentacja (`README.md`, `docs/`) — **po polsku** (docelowo PL + EN przez mechanizm tłumaczeń).
- Nazwy branchy, komunikaty commitów, nazwy w kodzie — **po angielsku**.

## 5. Git — obowiązkowy sposób pracy

Historia Git **podlega ocenie** (kryterium 7). Każda poniższa zasada jest wymogiem, nie sugestią.

### 5.1 Branch dla każdej zmiany
Nigdy nie commituj bezpośrednio na `main`.

```bash
git switch main
git pull --ff-only
git switch -c feature/nazwa-zadania
```

Nazewnictwo branchy (angielski, małe litery, myślniki):

| Prefiks | Przeznaczenie | Przykład |
|---|---|---|
| `feature/` | nowa funkcja | `feature/login-form`, `feature/ticket-repository` |
| `fix/` | naprawa błędu | `fix/nginx-routing` |
| `docs/` | dokumentacja | `docs/setup`, `docs/erd-diagram` |
| `chore/` | konfiguracja, narzędzia | `chore/composer-autoload` |
| `refactor/` | zmiana struktury bez zmiany zachowania | `refactor/extract-user-repository` |
| `test/` | testy | `test/ticket-validation` |

### 5.2 Małe, logiczne commity
Jeden commit = jedna logiczna zmiana. **Nie używaj `git add .`** — dodawaj konkretne pliki i sprawdzaj diff przed commitem:

```bash
git status
git add src/controllers/TicketController.php public/views/ticket.html.php
git diff --cached
git commit -m "feat: show ticket details from database"
```

Format komunikatu: `<prefiks>: <opis w trybie rozkazującym, po angielsku, małą literą, bez kropki na końcu>`.

| Prefiks | Zastosowanie | Przykład |
|---|---|---|
| `feat` | nowa funkcja | `feat: add registration form` |
| `fix` | naprawa błędu | `fix: validate empty email` |
| `docs` | dokumentacja | `docs: explain docker setup` |
| `refactor` | zmiana struktury | `refactor: extract user repository` |
| `test` | testy | `test: cover login validation` |
| `chore` | konfiguracja | `chore: configure nginx` |
| `style` | formatowanie, CSS bez zmiany logiki | `style: add dark theme variables` |

Zły komunikat: `update`, `fix bug`, `changes`, `docs/not-ready-readme`. Dobry: `feat: add ticket status update endpoint`.

### 5.3 Pull Request i merge
1. `git push -u origin feature/nazwa-zadania`
2. Otwórz Pull Request do `main`. Opis PR: problem, wykonane zmiany, jak przetestować, znane ograniczenia.
3. Po review scal przez **„Create a merge commit”**.

### 5.4 Czego NIE wolno robić
- **NIE squashuj commitów.** Nie wybieraj „Squash and merge”, nie używaj `git rebase -i` z `squash`/`fixup`.
- **NIE używaj `git push --force`** — nigdy na `main`, a na własnych branchach tylko w ostateczności i nigdy po otwarciu PR.
- **NIE rebase'uj** brancha współdzielonego z innymi. `git rebase main` tylko na własnym, niewypchniętym jeszcze branchu.
- **NIE commituj** `.env`, haseł, tokenów, kluczy API, `vendor/`, `node_modules/`, `.vs/`, `.idea/`, `uploads/`, logów ani `AGENTS.md`/`docs/`. Jeśli sekret trafił do historii — natychmiast go unieważnij, usunięcie w kolejnym commicie nie wystarczy.
- Sekrety i konfiguracja zależna od środowiska żyją **wyłącznie w `.env`** (ignorowany). W repo jest tylko `.env.example` z nazwami zmiennych i bezpiecznymi wartościami przykładowymi (`change_me`, `admin@example.com`). W kodzie czytaj je przez `getenv()`/`$_ENV`, nigdy nie wpisuj na sztywno.
- **NIE rób** jednego wielkiego commita „z całym projektem”. Historia ma pokazywać etapy pracy.

### 5.5 Agent a Git
Agent **może** tworzyć branche i commity lokalnie zgodnie z powyższymi zasadami. Agent **nie wykonuje** `git push`, nie otwiera PR i nie scala do `main` bez wyraźnego polecenia użytkownika. Przed każdym commitem agent pokazuje `git diff --cached` (lub jego podsumowanie).

## 6. Dokumentacja w `docs/` — obowiązek przy każdej zmianie

Katalog `docs/` to dziennik projektu. **Każda zmiana funkcjonalna, architektoniczna lub konfiguracyjna wymaga nowego pliku w `docs/`.** Nie edytuj starych wpisów (poza poprawą literówek) — dodaj nowy.

**`AGENTS.md` i `docs/` są w `.gitignore` — istnieją tylko lokalnie i nie trafiają na GitHub.** Nie commituj ich i nie próbuj wymuszać `git add -f`. Wszystko, co ma zobaczyć oceniający (zrzuty ekranu, raport WCAG, ERD, Security Bingo, eksport `.sql`), musi znaleźć się w `README.md` lub w śledzonych katalogach (`screenshots/`, `docker/db/`), nie w `docs/`.

### 6.1 Nazewnictwo
`docs/YYYY-MM-DD-krotki-opis-zmiany.md`, np. `docs/2026-11-03-ticket-repository.md`.

Pliki stałe (aktualizowane w miejscu, nie datowane):
- `docs/README.md` — indeks wszystkich wpisów (dopisuj każdy nowy plik).
- `docs/plan-i-backlog.md` — plan rozwoju i backlog (odpowiednik tablicy Trello). Aktualizuj statusy zadań.

### 6.2 Szablon wpisu

```markdown
# <Tytuł zmiany>

**Data:** YYYY-MM-DD
**Branch:** feature/...
**Kryteria oceny, których dotyczy:** np. 4 (Routing), 10 (PostgreSQL)

## Co zostało zrobione
- punkt po punkcie, konkretne pliki

## Dlaczego / decyzje
- uzasadnienie wyborów (dlaczego tak, a nie inaczej)

## Jak przetestować
- komendy, adresy URL, oczekiwany wynik

## Znane ograniczenia / TODO
- co zostało na później
```

### 6.3 Kiedy agent tworzy wpis
- Po każdym zadaniu, które kończy się commitem zmieniającym kod, konfigurację lub schemat bazy.
- Wpis powstaje **w trakcie pracy nad branchem**, ale nie jest commitowany (katalog ignorowany). W polu „Branch” wpisu podaj nazwę brancha, a po scaleniu PR dopisz jego numer — to jedyne powiązanie dziennika z historią Git.
- Dopisz plik do indeksu `docs/README.md`.
- Jeśli zmiana zamyka zadanie z backlogu — zaktualizuj status w `docs/plan-i-backlog.md`.

## 7. README.md — co utrzymywać

`README.md` jest oceniany (kryterium 1) i musi zawsze odzwierciedlać **rzeczywisty** stan projektu, nie plany. Gdy zmiana dotyka któregoś z poniższych obszarów, zaktualizuj README w tym samym PR:

- opis problemu i funkcji (tabela „Funkcje”),
- instrukcja uruchomienia od `git clone` do działającej aplikacji, lista zmiennych z `.env.example`,
- adresy usług (app, Mailpit, pgAdmin, Ollama),
- dane kont demonstracyjnych (loginy i hasła **tylko demo**, nigdy produkcyjne),
- zrzuty ekranu najważniejszych widoków (katalog `screenshots/` w root — śledzony przez Git, **nie** `docs/`),
- opis przepływu aplikacji i architektura (warstwy, kierunek zależności),
- diagram ERD jako blok ```` ```mermaid ```` `erDiagram` — zgodny z rzeczywistym schematem,
- tabela Security Bingo z dowodem (plik/linia) dla każdego pola,
- raport WCAG (narzędzie, data, wynik, zrzut, naprawione problemy),
- sposób uruchomienia testów,
- opis zadania CRON,
- link do wdrożenia i krótki opis deployu,
- autorzy i rzeczywisty zakres pracy.

## 8. Kryteria oceny — mapa dla agenta

Pełna lista kryteriów i aktualny status realizacji: [`docs/plan-i-backlog.md`](docs/plan-i-backlog.md). Skrót, czego pilnować przy każdej zmianie:

| Nr | Kryterium | Na co uważać w kodzie |
|---|---|---|
| 1 | README | aktualność, zrzuty, ERD, link do deployu |
| 2 | Docker | `docker compose up --build` działa na czystym środowisku; usługi po nazwach |
| 3 | Architektura | MVC: kontroler ≠ SQL ≠ HTML |
| 4 | Routing | trasa statyczna, regex, `{id}` z walidacją, query param, 400/404 |
| 5 | OOP backend | klasy, typy, interfejsy między warstwami |
| 6 | ERD Mermaid | w README, zgodny ze schematem |
| 7 | Git | małe commity, bez squash, wszystko w `main` przez PR |
| 8 | Realizacja tematu | główny proces (zgłoszenie → naprawa) działa end-to-end |
| 9 | HTML | semantyka, partiale, etykiety formularzy |
| 10 | PostgreSQL | PDO, parametryzacja, konfiguracja z `.env` |
| 11 | Złożoność bazy | kilka encji, klucze, ograniczenia, normalizacja |
| 12 | Eksport `.sql` | aktualny dump schematu + danych demo w repo |
| 13 | PHP | 8.3, typy, brak warningów |
| 14 | JavaScript | walidacja, zdarzenia, DOM, podział na moduły |
| 15 | Fetch API | min. 1 GET i 1 POST, JSON, loading/success/error |
| 16 | Design | spójne tokeny CSS, bez inline |
| 17 | Responsywność | ≥5 widoków, mobile/tablet/desktop |
| 18 | Dark/light | `data-theme` na `<html>`, localStorage, `prefers-color-scheme`, skrypt w `<head>` |
| 19 | WCAG | klawiatura, focus, alt, kontrast, raport w README |
| 20 | Logowanie | `password_verify`, bezpieczny komunikat, redirect |
| 21 | Sesja | `session_regenerate_id`, flagi cookie, uprawnienia z backendu |
| 22 | Uprawnienia | sprawdzanie przed każdą chronioną akcją, 401/403 |
| 23 | Role | min. USER i ADMIN w bazie |
| 24 | Wylogowanie | `session_destroy`, wygaszenie cookie, brak dostępu po „Wstecz” |
| 25 | Widok/trigger/funkcja/transakcja | min. 1, uzasadnione, w eksporcie `.sql` |
| 26 | Referencje | JOIN-y, przemyślane `ON DELETE` |
| 27 | Security Bingo | tabela z dowodami w README |
| 28 | Brak duplikacji | wspólne metody, partiale, serwisy |
| 29 | Czystość kodu | nazwy, krótkie metody, brak martwego kodu |
| 30 | Tłumaczenia | PL + EN z katalogu tłumaczeń, także walidacja |
| 31 | Testy jednostkowe | PHPUnit, przypadek poprawny i błędny, komenda w README |
| 32 | CRON | uzasadnione zadanie, log, idempotencja |
| 33 | PHPMailer | SMTP z `.env`, Mailpit lokalnie |
| 34 | Upload zdjęcia | rozmiar, MIME, rozszerzenie, unikalna nazwa, poza kodem, w bazie tylko ścieżka |
| 35 | `.env` | brak sekretów w kodzie, aktualny `.env.example` |
| 36 | Deploy | publiczny adres, odpowiada `main`, link w README |

## 9. Checklista przed zakończeniem zadania przez agenta

- [ ] Kod zgodny z sekcją 4 (strict_types, typy, parametryzowane SQL, `htmlspecialchars`).
- [ ] Nowe zmienne środowiskowe dopisane do `.env.example`.
- [ ] Nowe przestrzenie nazw dopisane do `composer.json`.
- [ ] Zmiana schematu bazy odzwierciedlona w pliku `.sql` w `docker/db/` i w ERD w README.
- [ ] Nowy wpis w `docs/YYYY-MM-DD-*.md` + dopisany do `docs/README.md` (lokalnie, bez commitu).
- [ ] Zaktualizowany status w `docs/plan-i-backlog.md`, jeśli zadanie z backlogu zostało zamknięte.
- [ ] README zaktualizowane, jeśli zmiana dotyka obszarów z sekcji 7.
- [ ] Praca na branchu `feature/…` (nie na `main`), commity małe i opisowe, bez `git add .`.
- [ ] Brak `.env`, sekretów, `vendor/`, `.vs/`, `AGENTS.md`, `docs/` w `git status`.
- [ ] Pliki tymczasowe/testowe stworzone poza repozytorium (np. `/tmp`) lub usunięte.
