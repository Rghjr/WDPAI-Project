# Inicjalizacja motywu przed CSS

**Data:** 2026-11-06
**Branch:** feature/shared-navigation
**Kryteria oceny, których dotyczy:** 18 (Dark/light)

## Co zostało zrobione
- Dodano synchroniczny skrypt w `<head>` pliku `public/views/layout.html.php`, przed arkuszem CSS.
- Skrypt odczytuje zapisany motyw, obsługuje niedostępne `localStorage` i wybiera preferencję systemową, jeśli nie ma poprawnego zapisu.

## Dlaczego / decyzje
- Ustawienie `data-theme` przed pobraniem CSS pozwala przeglądarce od razu wyrenderować właściwą paletę.

## Jak przetestować
- Wyczyścić `localStorage.theme` i sprawdzić, że motyw startuje zgodnie z preferencją systemową (domyślnie jasny).
- Ustawić `localStorage.theme` na `light` lub `dark`, odświeżyć stronę i sprawdzić, że zapisany wybór ma pierwszeństwo.

## Znane ograniczenia / TODO
- Inicjalizacja jest obecnie dodana do wspólnego layoutu; widoki muszą korzystać z niego, aby otrzymać to zachowanie.
