# Dokumentacja projektu AssetFix AI

Katalog `docs/` jest dziennikiem projektu. Każda zmiana funkcjonalna, architektoniczna lub konfiguracyjna ma własny, datowany wpis. Zasady prowadzenia dokumentacji opisuje [`AGENTS.md`](../AGENTS.md) (sekcja 6).

**Katalog jest w `.gitignore`** — to dokumentacja robocza, tylko lokalna. Materiały dla oceniającego (zrzuty, raport WCAG, ERD, Security Bingo) trafiają do `README.md` i śledzonego katalogu `screenshots/`.

## Pliki stałe

| Plik | Zawartość |
|---|---|
| [`plan-i-backlog.md`](plan-i-backlog.md) | Plan rozwoju aplikacji, backlog zadań (odpowiednik tablicy Trello) oraz mapa kryteriów oceny → status realizacji. |

## Wpisy datowane (od najnowszego)

| Data | Plik | Opis |
|---|---|---|
| 2026-11-12 | [`2026-11-12-nowe-podstrony-i-rozszerzenie-widokow.md`](2026-11-12-nowe-podstrony-i-rozszerzenie-widokow.md) | Rozszerzenie systemu o nowe widoki: Paszport maszyny (`/assets/{id}`), Rejestracja maszyny (`/assets/add`), Zarządzanie zespołem (`/admin/users`), Karta serwisanta (`/profile`) oraz Harmonogram przeglądów UDT (`/maintenance`). |
| 2026-11-11 | [`2026-11-11-modernizacja-ui-design-system.md`](2026-11-11-modernizacja-ui-design-system.md) | Kompleksowa modernizacja widoków (Dashboard, Zlecenia, Maszyny, Logowanie, 404) oraz rozbudowa responsywnego systemu styli z Font Awesome. |
| 2026-11-06 | [`2026-11-06-poprawki-motywu-przyciskow.md`](2026-11-06-poprawki-motywu-przyciskow.md) | Poprawiono tło przycisku mapy i środkową pozycję trybu systemowego. |
| 2026-11-06 | [`2026-11-06-sticky-nawigacja-i-kontrast.md`](2026-11-06-sticky-nawigacja-i-kontrast.md) | Przyklejono nawigację i poprawiono kontrast przycisku mapy. |
| 2026-11-06 | [`2026-11-06-powrot-do-motywu-systemowego.md`](2026-11-06-powrot-do-motywu-systemowego.md) | Dodano powrót do automatycznego motywu systemowego. |
| 2026-11-06 | [`2026-11-06-motyw-systemowy.md`](2026-11-06-motyw-systemowy.md) | Przywrócono systemowy motyw jako domyślny. |
| 2026-11-06 | [`2026-11-06-domyslny-motyw-jasny.md`](2026-11-06-domyslny-motyw-jasny.md) | Ustawiono jasny motyw jako domyślny niezależnie od systemu. |
| 2026-11-06 | [`2026-11-06-styl-przelacznika-motywu.md`](2026-11-06-styl-przelacznika-motywu.md) | Ulepszono wygląd przełącznika jasnego/ciemnego motywu. |
| 2026-11-06 | [`2026-11-06-przelacznik-motywu.md`](2026-11-06-przelacznik-motywu.md) | Dodano przełącznik motywu do wspólnej nawigacji. |
| 2026-11-06 | [`2026-11-06-inicjalizacja-motywu.md`](2026-11-06-inicjalizacja-motywu.md) | Motyw jest ustawiany przed załadowaniem CSS. |
| 2026-11-06 | [`2026-11-06-kolory-tokeny-css.md`](2026-11-06-kolory-tokeny-css.md) | Zastąpiono kolory w regułach CSS tokenami motywu. |
| 2026-11-06 | [`2026-11-06-kolory-motywow.md`](2026-11-06-kolory-motywow.md) | Dodano tokeny kolorów light/dark w CSS. |
| 2026-11-06 | [`2026-11-06-layout-widokow.md`](2026-11-06-layout-widokow.md) | Dodany bazowy wspólny layout widoków. |
| 2026-11-05 | [`2026-11-05-wspolna-nawigacja.md`](2026-11-05-wspolna-nawigacja.md) | Wydzielona nawigacja dołączana do widoków. |
| 2026-10-27 | [`2026-10-27-stan-projektu.md`](2026-10-27-stan-projektu.md) | Inwentaryzacja projektu: co istnieje w repozytorium, jak działa, czego brakuje względem kryteriów oceny. |

## Jak dodać nowy wpis

1. Utwórz plik `docs/YYYY-MM-DD-krotki-opis.md` według szablonu z `AGENTS.md`.
2. Dopisz wiersz do tabeli powyżej (na górze — najnowsze pierwsze).
3. Jeśli wpis zamyka zadanie z backlogu, zaktualizuj status w `plan-i-backlog.md`.
4. Nie commituj — katalog jest ignorowany. Po scaleniu PR dopisz jego numer w polu „Branch” wpisu.
