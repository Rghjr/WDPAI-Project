# Przyklejona nawigacja i kontrast przycisku mapy

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 17 (Responsywność), 19 (WCAG)

## Co zostało zrobione
- Ustawiono górną nawigację jako sticky z warstwą nad przewijaną treścią.
- Dodano osobny token koloru tekstu dla ciemnego przycisku akcji, używany przez „Otwórz mapę tras”.

## Dlaczego / decyzje
- Nawigacja pozostaje dostępna podczas przewijania, a etykieta ciemnego przycisku zachowuje kontrast w obu motywach.

## Jak przetestować
- Przewinąć dłuższą stronę i sprawdzić, że nawigacja pozostaje przy górnej krawędzi.
- W jasnym i ciemnym motywie sprawdzić czytelność tekstu na przycisku „Otwórz mapę tras”.

## Znane ograniczenia / TODO
- Brak.
