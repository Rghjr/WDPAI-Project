# Modernizacja UI i wdrożenie systemu widoków Enterprise

**Data:** 2026-11-11
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 9 (HTML), 14 (JavaScript), 16 (Design), 17 (Responsywność), 18 (Dark/light), 20 (Logowanie), 28 (Brak duplikacji)

## Co zostało zrobione
- **System styli i tokenów CSS (`public/css/style.css`):**
  - Uporządkowano i zdefiniowano pełny zestaw tokenów CSS dla motywu jasnego (`data-theme="light"`), ciemnego (`data-theme="dark"`) oraz systemowego (`prefers-color-scheme`).
  - Rozszerzono paletę barw o kolory modułu predykcyjnego AI (Ollama Smart Diagnosis), statusów SLA (krytyczny, ostrzeżenie, sukces) oraz powierzchni kart i tabel.
  - Zastąpiono sztywne ograniczenie szerokości do telefonu (`max-width: 440px`) w pełni responsywnym kontenerem `container` / `app-container` (mobile-first, z płynnym rozszerzaniem do `1280px` na ekranach desktopowych).
  - Wdrożono komponenty: karty statystyk KPI z ikonami, siatkę szybkich akcji (Quick Actions), widget Smart Diagnosis AI z podglądem telemetrii na żywo, nowoczesne tabele z paskiem filtrów i wyszukiwarką, formularze z obsługą stanów focus/hover oraz karty logowania z kontami demonstracyjnymi.
- **Wspólna nawigacja (`public/views/partials/navigation.html.php`):**
  - Przekształcono nawigację w profesjonalny pasek Enterprise Topbar: logo AssetFix.AI z sygnetem zębatki, badge "Enterprise Core", linki modułowe z ikonami Font Awesome i wskaźnikami aktywnych tras, status IoT Hub ("Baza Poznań 99.9% Online"), zintegrowany przełącznik motywu (Dark/Light/System) oraz profil serwisanta.
- **Pulpit operacyjny (`public/views/home.html.php`):**
  - Zastąpiono emotikony profesjonalnymi ikonami Font Awesome.
  - Dodano kafelki KPI (Dzisiejsze zlecenia, Pilne/Krytyczne SLA, Sprawność floty, Park maszynowy).
  - Wprowadzono dwukolumnowy układ: zlecenia na dziś z priorytetami SLA oraz panel boczny Smart Diagnosis AI (podgląd wibracji FFT, temperatury, ciśnienia i rekomendacji naprawy).
- **Rejestr zgłoszeń (`public/views/tickets.html.php`) i widok zlecenia (`public/views/ticket.html.php`):**
  - Zamiast surowej listy HTML utworzono pełną tabelę zleceń z filtrami statusu i badgami priorytetów.
  - Na karcie zlecenia dodano dwukolumnowy układ z metadanymi maszyny, formularzem zmiany statusu, sekcją uploadu zdjęć oraz dedykowanym panelem analizy AI.
- **Park maszynowy (`public/views/assets.html.php`):**
  - Dodano kafelki stanu floty oraz czytelną tabelę urządzeń z numerami seryjnymi, kategoriami, statusami sprawności i datami przeglądów.
- **Formularz awarii (`public/views/add-ticket.html.php`):**
  - Dodano dwukolumnowy formularz zgłaszania awarii ze wskazówkami dla silnika AI Ollama i uploadem zdjęć.
- **Ekran logowania (`public/views/login.html.php`):**
  - Dodano nowoczesny panel logowania z kafelkami szybkiego wstawiania kont demo (`admin@assetfix.ai`, `technik@assetfix.ai`).
- **Ekran błędu 404 (`public/views/not-found.html.php`):**
  - Dodano estetyczny komunikat błędu z przyciskiem powrotu do pulpitu.

## Dlaczego / decyzje
- Wcześniejsze pliki prototypowe ze Stitch zawierały chaotyczny, niezorganizowany kod z ciężkimi bibliotekami CDN (Tailwind CDN, Material Symbols), co gryzło się z architekturą projektu i mechanizmem motywu ciemnego/jasnego.
- Zamiast kopiować nieprzystosowany kod, wyekstrahowano najlepsze założenia wizualne (kompozycja, hierarchia, paleta, karty KPI, telemetria) i przepisano je w czystym, semantycznym CSS i PHP, zachowując 100% zgodności z wytycznymi projektu WDPAI (`AGENTS.md`).
- Użyto zarejestrowanego zestawu Font Awesome Kit, co gwarantuje spójność ikon we wszystkich widokach.

## Jak przetestować
- Otworzyć aplikację w przeglądarce pod adresem `http://localhost:8080/`.
- Przetestować podstrony:
  - `/` — Pulpit operacyjny z kartami KPI, listą zleceń i panelem Smart Diagnosis AI.
  - `/tickets` — Lista zgłoszeń z filtrami i tabelą.
  - `/tickets/1` — Szczegóły zlecenia, formularz zmiany statusu i rekomendacja AI.
  - `/tickets/add` — Formularz zgłaszania nowej awarii.
  - `/assets` — Park maszynowy i rejestr urządzeń.
  - `/login` — Panel logowania z kafelkami kont demonstracyjnych.
- Przetestować przełącznik motywu (słońce / księżyc / system) — sprawdzić działanie w trybie jasnym i ciemnym.
- Zmienić rozmiar okna (mobile, tablet, desktop) — sprawdzić responsywność.

## Znane ograniczenia / TODO
- Kontrolery przekazują obecnie dane demonstracyjne (zgodnie z harmonogramem Sprint 0/1); podpięcie bazy danych PostgreSQL (PDO, repozytoria) zaplanowane jest na Sprint 1/2.
