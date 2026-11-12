# Przełącznik motywu w nawigacji

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 9 (HTML), 14 (JavaScript), 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Dodano dostępny przycisk przełączania motywu do `public/views/partials/navigation.html.php`.
- Skrypt `public/js/theme.js` zmienia motyw, zapisuje wybór i aktualizuje etykietę oraz ikonę przycisku.
- Dodano style przycisku korzystające z tokenów kolorów; skrypt ładowany jest przez wspólny partial na wszystkich widokach używających nawigacji.

## Dlaczego / decyzje
- Przełącznik w nawigacji jest dostępny niezależnie od aktywnej strony, a wybór użytkownika jest zapamiętywany w `localStorage`.

## Jak przetestować
- Kliknąć przycisk słońca/księżyca i sprawdzić zmianę palety.
- Odświeżyć stronę i sprawdzić zachowanie zapisanego motywu.
- Użyć klawiatury, aby przejść do przycisku i go aktywować; etykieta dostępności powinna wskazywać kolejny możliwy motyw.

## Znane ograniczenia / TODO
- Wspólny layout nadal nie jest używany przez wszystkie widoki, więc inicjalizacja motywu przed CSS działa tylko tam, gdzie layout jest renderowany.
