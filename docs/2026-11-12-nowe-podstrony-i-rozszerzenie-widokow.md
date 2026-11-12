# Rozszerzenie systemu o nowe podstrony i widoki EAM

**Data:** 2026-11-12
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 4 (Routing), 8 (Realizacja tematu), 9 (HTML), 16 (Design), 17 (Responsywność), 22 (Uprawnienia), 23 (Role), 32 (CRON)

## Co zostało zrobione
- **Nowe podstrony i widoki w systemie AssetFix AI:**
  - `/assets/{id}` (`public/views/asset.html.php`) — Paszport techniczny maszyny (EAM Asset Passport) ze specyfikacją DTR, statusem dozoru UDT, historią powiązanych zgłoszeń, podglądem telemetrii IoT na żywo oraz dokumentacją do pobrania.
  - `/assets/add` (`public/views/add-asset.html.php`) — Formularz rejestracji nowej maszyny do parku maszynowego z danymi identyfikacyjnymi, przypisaniem do klienta, parametrami dozoru UDT i uploadem dokumentacji DTR.
  - `/admin/users` (`public/views/users.html.php`) — Panel zarządzania zespołem serwisowym i uprawnieniami (role ADMIN / TECHNICIAN, certyfikaty SEP, UDT, IRATA, statusy dostępności, przypisane zlecenia).
  - `/profile` (`public/views/profile.html.php`) — Karta tożsamości i profil serwisanta (dane kontaktowe, oficjalne certyfikaty SEP i UDT z datami ważności, statystyki wydajności KPI, formularz zmiany hasła oraz preferencje alertów).
  - `/maintenance` (`public/views/maintenance.html.php`) — Harmonogram przeglądów okresowych i dozoru technicznego UDT powiązany z automatyzacją alertów CRON (&lt; 7 dni).
- **Backend i kontrolery:**
  - Utworzono `src/controllers/UserController.php` z obsługą `/admin/users`, `/profile` oraz `/login`.
  - Rozbudowano `src/controllers/AssetController.php` o metody `show(int $id)`, `add()` oraz `maintenance()`.
  - Zarejestrowano nowe trasy w `public/index.php`.
- **Nawigacja i spójność linków:**
  - Zaktualizowano `public/views/partials/navigation.html.php`, dodając linki do `/maintenance` (Przeglądy EAM), `/admin/users` (Zespół) oraz przekierowanie pigułki użytkownika do `/profile`.
  - Połączono widok parku maszynowego (`/assets`) z paszportem maszyny (`/assets/{id}`) i rejestracją nowego urządzenia (`/assets/add`).
  - W widoku zlecenia (`/tickets/{id}`) dodano bezpośredni odnośnik do paszportu technicznego uszkodzonej maszyny.
- **Style i tokeny CSS:**
  - Dodano style dla układu formularzy (`form-grid-2`, `form-section`, `form-actions`), listy dokumentów (`file-list`, `file-item`) oraz komponentów profilowych (`avatar-circle`, `user-profile-preview`).

## Dlaczego / decyzje
- Wcześniejsza wersja aplikacji posiadała podstawowy szkielet kilku podstron. Uzupełnienie o paszport maszyny, formularz dodawania zasobów, moduł zarządzania zespołem, profil technika oraz harmonogram przeglądów UDT domyka spójny obieg biznesowy platformy EAM / CMMS.
- Realizuje wymagania kryteriów 8 (proces end-to-end), 17 (ponad 5 pełnych, responsywnych widoków), 22/23 (role i uprawnienia zespołu) oraz 32 (kontekst zadania CRON).

## Jak przetestować
- Uruchomić aplikację pod adresem `http://localhost:8080/`.
- Sprawdzić działanie tras:
  - `/assets/1`, `/assets/2`, `/assets/3` — Paszport techniczny maszyny z telemetrią i historią awarii.
  - `/assets/add` — Formularz rejestracji nowej maszyny do bazy.
  - `/admin/users` — Rejestr pracowników, ról i uprawnień technicznych (SEP/UDT).
  - `/profile` — Profil zalogowanego serwisanta, paszport uprawnień i zmiana hasła.
  - `/maintenance` — Harmonogram przeglądów i alertów CRON.
- Przetestować spójność nawigacji górnej na wszystkich ekranach.

## Znane ograniczenia / TODO
- Docelowe podpięcie zapytań SQL do PostgreSQL (PDO) w ramach kolejnych etapów sprintu z warstwą repozytoriów.
