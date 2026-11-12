# Kolory motywów jasnego i ciemnego

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Dodano tokeny kolorów jasnego motywu oraz nadpisania dla `html[data-theme="dark"]` w `public/css/style.css`.
- Dodano obsługę `prefers-color-scheme: dark`, gdy atrybut motywu nie został ustawiony.
- Podmieniono część bezpośrednich kolorów elementów na zmienne, aby reagowały na motyw.

## Dlaczego / decyzje
- Tokeny pozwalają przełączać paletę w jednym miejscu i zachować czytelność kart, etykiet oraz tekstu w obu motywach.

## Jak przetestować
- Ustawić w konsoli przeglądarki `document.documentElement.dataset.theme = 'dark'`, a następnie `light`; sprawdzić tło, teksty, karty i znaczniki.
- Usunąć `data-theme` i zmienić preferencję kolorów systemu, aby sprawdzić automatyczny wybór motywu.

## Znane ograniczenia / TODO
- `theme.js` nie przełącza jeszcze motywu ani nie zapisuje wyboru użytkownika.
