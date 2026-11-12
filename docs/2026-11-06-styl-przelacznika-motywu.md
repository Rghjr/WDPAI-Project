# Styl przełącznika motywu

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 16 (Design), 18 (Dark/light), 19 (WCAG)

## Co zostało zrobione
- Ostylowano przycisk motywu jako kompaktowy przełącznik z przesuwaną ikoną.
- Dodano stany hover i focus oraz ograniczenie animacji dla `prefers-reduced-motion`.

## Dlaczego / decyzje
- Przełącznik korzysta z tokenów kolorów i zachowuje widoczny fokus oraz czytelność w obu motywach.

## Jak przetestować
- Użyć przełącznika myszą i klawiaturą w jasnym oraz ciemnym motywie; sprawdzić animację i widoczny fokus.
- Włączyć systemową opcję ograniczenia animacji i sprawdzić, że przełączenie działa bez animacji.

## Znane ograniczenia / TODO
- Ikona słońca/księżyca zależy od fontu systemowego.
