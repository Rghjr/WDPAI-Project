# Wspólna nawigacja widoków

**Data:** 2026-11-05
**Branch:** main
**Kryteria oceny, których dotyczy:** 3 (MVC), 9 (HTML), 16 (Design), 17 (Responsywność)

## Co zostało zrobione
- Dodano `public/views/partials/navigation.html.php` jako wspólny komponent nawigacji.
- Dołączono partial do wszystkich istniejących widoków i dodano podstawowe style responsywne.

## Dlaczego / decyzje
- Wspólna nawigacja ogranicza duplikację i ułatwia utrzymywanie tych samych odnośników na wszystkich stronach.

## Jak przetestować
- Otworzyć pulpit, zgłoszenia, szczegóły zgłoszenia, maszyny, formularz dodania zgłoszenia, logowanie oraz widoki projektu i 404; na każdej stronie powinna być widoczna ta sama nawigacja.

## Znane ograniczenia / TODO
- Link „Logowanie” pozostaje dostępny, ponieważ aplikacja nie ma jeszcze wspólnego stanu uwierzytelnienia w widokach.
