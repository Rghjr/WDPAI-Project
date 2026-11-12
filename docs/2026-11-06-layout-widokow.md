# Wspólny layout widoków

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 3 (MVC), 9 (HTML), 16 (Design)

## Co zostało zrobione
- Dodano `public/views/layout.html.php` z podstawową strukturą HTML, wspólną nawigacją, arkuszem CSS i skryptem motywu.
- Tytuł strony jest escapowany przed umieszczeniem w `<title>`; treść widoku jest przekazywana jako `$content`.

## Dlaczego / decyzje
- Wspólny szablon stanowi bazę do ujednolicenia nagłówka dokumentu i nawigacji w widokach.

## Jak przetestować
- Otworzyć plik przez renderer widoków po przekazaniu zmiennych `pageTitle` i `content`; sprawdzić tytuł, nawigację i treść strony.

## Znane ograniczenia / TODO
- Renderer aplikacji nie został jeszcze przełączony na layout; istniejące widoki nadal generują pełny dokument HTML.
