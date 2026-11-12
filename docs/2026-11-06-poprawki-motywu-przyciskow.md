# Poprawki kontrastu przycisków motywu

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light), 19 (WCAG)

## Co zostało zrobione
- Rozjaśniono tło przycisku „Otwórz mapę tras” w ciemnym motywie i przypisano mu osobny token tła.
- Ustawiono ikonę przełącznika w centralnej pozycji, gdy aktywny jest tryb systemowy, niezależnie od tego, czy system wybrał jasny, czy ciemny motyw.

## Dlaczego / decyzje
- Jaśniejsze tło odróżnia przycisk od tła strony w ciemnym motywie, a stała pozycja środkowa komunikuje tryb automatyczny.

## Jak przetestować
- Przełączyć stronę na ciemny motyw i sprawdzić czytelność przycisku „Otwórz mapę tras”.
- Wybrać tryb systemowy przy systemowej preferencji jasnej, a następnie ciemnej; ikona suwaka powinna pozostać na środku.

## Znane ograniczenia / TODO
- Brak.
