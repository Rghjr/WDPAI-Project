# AssetFix AI

System B2B dla firm serwisowych łączący panel menedżera z aplikacją mobilną technika, automatyzujący zarządzanie zgłoszeniami, planowanie tras oraz diagnostykę usterek przy wsparciu lokalnej sztucznej inteligencji.

## Funkcje

| Obszar | Co robi |
|---|---|
| Panel Menedżera (Desktop) | Zarządzanie harmonogramem, planowanie tras serwisowych oraz podgląd lokalizacji awarii na interaktywnej mapie. |
| Aplikacja Technika (Mobile) | Odbiór powiadomień, nawigacja GPS, raportowanie czasu pracy oraz bezpieczny upload protokołów PDF i zdjęć z terenu. |
| Inteligentna Diagnostyka (AI) | Analiza objawów wpisanych przez technika (model Ollama) i dopasowywanie historii z SQL w celu sugestii przyczyn i potrzebnych części. |
| Baza Wiedzy (Streaming) | Strumieniowe odtwarzanie (HTTP Range) wideo-instrukcji naprawy bezpośrednio w aplikacji dla techników. |
| Automatyzacja powiadomień | Skrypty CRON monitorujące terminy i rozsyłające automatyczne przypomnienia e-mail (obsługa przez Mailpit) o przeglądach okresowych. |

## Tech stack

| Warstwa | Technologie |
|---|---|
| Backend | PHP 8.3 (Architektura MVC, Autorski Routing, PDO/DAO) |
| Serwer HTTP | Nginx |
| Baza danych | PostgreSQL |
| Sztuczna Inteligencja | Ollama (Local LLM) |
| Aplikacje Klienckie | C# (.NET MAUI), Leaflet JS |
| Konteneryzacja | Docker Compose |

## Szybki start
```bash
git clone https://github.com/Rghjr/WDPAI-Project.git
cd WDPAI-Project
docker compose up --build -d
```

Aplikacja: http://localhost:8080

## Struktura projektu

- `/public` — Punkt wejścia aplikacji (`index.php`), arkusze stylów (`/css`) oraz pliki interfejsu (`/views`).
- `/src` — Główny kod źródłowy backendu, logika biznesowa, autorski routing oraz modele komunikujące się z bazą danych i modelem LLM.
- `docker-compose.yaml` — Orkiestracja kontenerów dla aplikacji, bazy PostgreSQL, serwera Nginx oraz usług pobocznych.
- `.env.example` — Szablon niezbędnych zmiennych środowiskowych i kluczy dostępu.

## Zasady developmentu

- Branch dla każdej funkcji.
- Małe, logiczne commity.
- Sekrety wyłącznie w .env.

## Autorzy

- Strzępek Krystian — Architektura backendu w oparciu o PHP MVC, konteneryzacja środowiska (Docker), integracja modelu językowego Ollama, budowa widoków responsywnych oraz konfiguracja bazy danych i routingu.