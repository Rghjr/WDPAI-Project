# Powrót do motywu systemowego

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 14 (JavaScript), 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Dodano trzeci tryb przełącznika: `system`.
- Przełącznik cyklicznie zmienia tryby systemowy → jasny → ciemny → systemowy.
- Tryb systemowy jest zapisywany w `localStorage` i ponownie reaguje na zmianę preferencji systemowej.
- Ikona półksiężyca oznacza tryb systemowy, a etykieta dostępności opisuje następny tryb.

## Dlaczego / decyzje
- Użytkownik może wrócić do automatycznego dopasowania bez ręcznego czyszczenia pamięci przeglądarki.

## Jak przetestować
- Kliknąć przełącznik trzy razy i sprawdzić kolejno tryb jasny, ciemny i systemowy.
- W trybie systemowym zmienić preferencję urządzenia i sprawdzić, że paleta podąża za nią.
- W trybie jasnym lub ciemnym zmienić preferencję systemową i sprawdzić, że ręczny wybór pozostaje aktywny.

## Znane ograniczenia / TODO
- Brak.
