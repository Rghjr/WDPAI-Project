# Motyw systemowy jako ustawienie domyślne

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Przywrócono wybór motywu systemowego jako domyślny, gdy użytkownik nie ma zapisanego wyboru.
- Przełącznik zachowuje ręczny wybór w `localStorage`; zmiana preferencji systemu aktualizuje motyw tylko wtedy, gdy użytkownik nie wybrał go ręcznie.
- Ujednolicono inicjalizację na widokach z nawigacją, także tych, które nie korzystają z layoutu.

## Dlaczego / decyzje
- Domyślny wygląd aplikacji odpowiada ustawieniu jasnego lub ciemnego motywu w systemie użytkownika.

## Jak przetestować
- Usunąć `localStorage.theme`, zmienić ustawienie motywu systemowego i odświeżyć stronę; sprawdzić, że strona i przycisk odzwierciedlają system.
- Ręcznie przełączyć motyw, zmienić preferencję systemową i odświeżyć stronę; zapisany wybór powinien pozostać aktywny.

## Znane ograniczenia / TODO
- Widoki bez wspólnego layoutu inicjalizują motyw z `theme.js`, który jest ładowany po rozpoczęciu renderowania CSS.
