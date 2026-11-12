# Kolory CSS oparte na tokenach

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Zastąpiono bezpośrednie kolory w regułach CSS zmiennymi, w tym kolory tekstu na przyciskach, przezroczyste obramowanie oraz cienie.
- Dodano tokeny dla kolorów kontrastowych i cieni w paletach jasnej i ciemnej.

## Dlaczego / decyzje
- Wszystkie kolory elementów interfejsu można teraz zmienić centralnie w tokenach motywu.

## Jak przetestować
- Ustawić `data-theme="light"` i `data-theme="dark"` na `<html>` i sprawdzić, czy teksty, przyciski, karty, obramowania oraz cienie reagują na motyw.

## Znane ograniczenia / TODO
- Skrypt `theme.js` nie ustawia jeszcze motywu; tryby można zweryfikować przez zmianę atrybutu HTML lub preferencję systemową.
