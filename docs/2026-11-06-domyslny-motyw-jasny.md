# Jasny motyw jako domyślny

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light)

## Co zostało zrobione
- Ustawiono motyw jasny jako domyślny w inicjalizacji przed CSS, jeśli nie ma poprawnego zapisu w `localStorage`.
- Usunięto automatyczne przełączanie motywu przez CSS i JavaScript zgodnie z preferencją systemową.
- Zsynchronizowano skrypt przełącznika z ikoną `.theme-toggle__icon` w nawigacji.

## Dlaczego / decyzje
- Domyślny wygląd pozostaje jasny niezależnie od ustawień systemu; ręczny wybór nadal może włączyć ciemny motyw.

## Jak przetestować
- Ustawić systemowy motyw ciemny, usunąć `localStorage.theme` i odświeżyć widok korzystający z layoutu — strona powinna być jasna.
- Kliknąć przełącznik i sprawdzić zmianę palety oraz ikony.

## Znane ograniczenia / TODO
- Widoki nadal nie korzystają wspólnie z `layout.html.php`, więc zapisany motyw nie jest odtwarzany przed CSS na wszystkich widokach.
