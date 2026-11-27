-- AssetFix AI — PostgreSQL 16 Demo Seed Data
-- Hasło dla wszystkich kont demonstracyjnych: AssetFix2026!

CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- ============================================================================
-- 1. ROLE
-- ============================================================================

INSERT INTO roles (name, description) VALUES
    ('ADMIN', 'Menedżer serwisu i dyspozytor — pełny dostęp do maszyn, zgłoszeń i zespołu'),
    ('TECHNICIAN', 'Technik serwisu terenowego — realizacja przypisanych zgłoszeń i diagnostyka');

-- ============================================================================
-- 2. UŻYTKOWNICY (1 ADMIN, 3 TECHNICIAN)
-- ============================================================================

INSERT INTO users (
    role_id, email, password_hash, first_name, last_name,
    employee_code, phone, base_location, is_active
) VALUES
    (
        (SELECT id FROM roles WHERE name = 'ADMIN'),
        'admin@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Janina',
        'Wiśniewska',
        'MGR-001',
        '+48 600 100 200',
        'Poznań (Centrala)',
        TRUE
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'piotr.kowalski@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Piotr',
        'Kowalski',
        'TECH-042',
        '+48 601 234 567',
        'Poznań (Region Wielkopolska)',
        TRUE
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'marek.nowak@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Marek',
        'Nowak',
        'TECH-043',
        '+48 602 345 678',
        'Bolechowo / Oborniki',
        TRUE
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'anna.zielinska@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Anna',
        'Zielińska',
        'TECH-044',
        '+48 603 456 789',
        'Kraków (Region Małopolska)',
        TRUE
    );

-- ============================================================================
-- 3. KLIENCI
-- ============================================================================

INSERT INTO clients (name, address, city, contact_email, contact_phone, latitude, longitude) VALUES
    (
        'Polenergia Farma Margonin S.A.',
        'Wieża B-12, Park Wiatrowy Margonin',
        'Margonin',
        'utrzymanie@polenergia-demo.pl',
        '+48 67 284 11 00',
        52.973400,
        16.992100
    ),
    (
        'Biurowiec Pixel Poznań Sp. z o.o.',
        'ul. Grunwaldzka 182',
        'Poznań',
        'administracja@pixel-demo.pl',
        '+48 61 850 22 10',
        52.398800,
        16.875400
    ),
    (
        'Solaris Bus & Coach Sp. z o.o.',
        'ul. Obornicka 46, Bolechowo-Osiedle',
        'Bolechowo',
        'ur@solaris-demo.pl',
        '+48 61 667 23 00',
        52.536400,
        16.941200
    ),
    (
        'Zakład Produkcyjny Wielkopolska Sp. z o.o.',
        'ul. Przemysłowa 15',
        'Swarzędz',
        'serwis@zpw-demo.pl',
        '+48 61 817 44 55',
        52.411200,
        17.078900
    );

-- ============================================================================
-- 4. KATEGORIE MASZYN
-- ============================================================================

INSERT INTO asset_categories (name, description) VALUES
    ('OZE / Turbiny Wiatrowe', 'Turbiny wiatrowe, przekładnie główne oraz systemy pitch/yaw'),
    ('Dźwigi i Windy Osobowe', 'Dźwigi osobowe i towarowe podlegające dozorowi UDT'),
    ('Sprężarki Przemysłowe', 'Sprężarki śrubowe i tłokowe oraz zbiorniki ciśnieniowe'),
    ('Maszyny Produkcyjne CNC', 'Centra obróbcze CNC, tokarki i prasy hydrauliczne');

-- ============================================================================
-- 5. PARK MASZYNOWY (8 MASZYN, W TYM PRZEGLĄDY ZA 3 I 5 DNI DLA CRON)
-- ============================================================================

INSERT INTO assets (
    client_id, category_id, assigned_technician_id,
    name, serial_number, status, manufacturer, model, production_year,
    udt_number, location_details, last_inspection_at, next_inspection_at,
    udt_valid_until, operating_hours
) VALUES
    (
        (SELECT id FROM clients WHERE city = 'Margonin'),
        (SELECT id FROM asset_categories WHERE name = 'OZE / Turbiny Wiatrowe'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Turbina Wiatrowa V90 #04',
        'TURB-2024-9004',
        'OUT_OF_SERVICE',
        'Vestas Wind Systems A/S',
        'V90-2.0 MW Pitch Controlled',
        2021,
        'UDT-POZ-7712/2021',
        'Wieża B-12, Gondola górna',
        CURRENT_DATE - INTERVAL '300 days',
        CURRENT_DATE + INTERVAL '3 days',
        CURRENT_DATE + INTERVAL '65 days',
        18420
    ),
    (
        (SELECT id FROM clients WHERE city = 'Poznań'),
        (SELECT id FROM asset_categories WHERE name = 'Dźwigi i Windy Osobowe'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Winda Osobowa KONE B3',
        'ELEV-8832-K3',
        'IN_REPAIR',
        'KONE Corporation',
        'MonoSpace 500 DX',
        2022,
        'UDT-POZ-ELEV-9941',
        'Szyb Pasażerski B3, Piętra -1 do +6',
        CURRENT_DATE - INTERVAL '180 days',
        CURRENT_DATE + INTERVAL '5 days',
        CURRENT_DATE + INTERVAL '185 days',
        9640
    ),
    (
        (SELECT id FROM clients WHERE city = 'Bolechowo'),
        (SELECT id FROM asset_categories WHERE name = 'Sprężarki Przemysłowe'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Sprężarka Śrubowa Atlas Copco GA 75',
        'COMP-AC-7599',
        'OPERATIONAL',
        'Atlas Copco Airpower',
        'GA 75 VSD+ FF',
        2023,
        'UDT-POZ-ZB-3129',
        'Hala Montażowa H-4, Sprężarkownia Centralna',
        CURRENT_DATE - INTERVAL '90 days',
        CURRENT_DATE + INTERVAL '90 days',
        CURRENT_DATE + INTERVAL '450 days',
        12150
    ),
    (
        (SELECT id FROM clients WHERE city = 'Swarzędz'),
        (SELECT id FROM asset_categories WHERE name = 'Maszyny Produkcyjne CNC'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Centrum Obróbcze DMG MORI CMX 1100 V',
        'CNC-DMG-1104',
        'OPERATIONAL',
        'DMG MORI',
        'CMX 1100 V',
        2022,
        NULL,
        'Hala A, Stanowisko 04',
        CURRENT_DATE - INTERVAL '120 days',
        CURRENT_DATE + INTERVAL '60 days',
        NULL,
        7420
    ),
    (
        (SELECT id FROM clients WHERE city = 'Margonin'),
        (SELECT id FROM asset_categories WHERE name = 'OZE / Turbiny Wiatrowe'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Turbina Wiatrowa V90 #07',
        'TURB-2024-9007',
        'OPERATIONAL',
        'Vestas Wind Systems A/S',
        'V90-2.0 MW Pitch Controlled',
        2021,
        'UDT-POZ-7715/2021',
        'Wieża B-15',
        CURRENT_DATE - INTERVAL '200 days',
        CURRENT_DATE + INTERVAL '45 days',
        CURRENT_DATE + INTERVAL '165 days',
        17980
    ),
    (
        (SELECT id FROM clients WHERE city = 'Poznań'),
        (SELECT id FROM asset_categories WHERE name = 'Dźwigi i Windy Osobowe'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Dźwig Towarowy OTIS T2',
        'ELEV-4410-OT',
        'OPERATIONAL',
        'OTIS Elevator Company',
        'Gen2 Robust 2500',
        2020,
        'UDT-POZ-ELEV-5502',
        'Szyb Techniczny Zachodni',
        CURRENT_DATE - INTERVAL '330 days',
        CURRENT_DATE + INTERVAL '35 days',
        CURRENT_DATE + INTERVAL '35 days',
        11200
    ),
    (
        (SELECT id FROM clients WHERE city = 'Bolechowo'),
        (SELECT id FROM asset_categories WHERE name = 'Sprężarki Przemysłowe'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Zbiornik Ciśnieniowy Airpol 2000L',
        'TANK-AP-2008',
        'OPERATIONAL',
        'Airpol Sp. z o.o.',
        'ZC-2000/11',
        2023,
        'UDT-POZ-ZB-3130',
        'Hala Montażowa H-4, Sekcja B',
        CURRENT_DATE - INTERVAL '60 days',
        CURRENT_DATE + INTERVAL '300 days',
        CURRENT_DATE + INTERVAL '300 days',
        12150
    ),
    (
        (SELECT id FROM clients WHERE city = 'Swarzędz'),
        (SELECT id FROM asset_categories WHERE name = 'Maszyny Produkcyjne CNC'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Prasa Hydrauliczna Bystronic Xpert 150',
        'PRESS-BYS-1502',
        'IN_REPAIR',
        'Bystronic',
        'Xpert 150/3100',
        2019,
        'UDT-POZ-PR-1190',
        'Hala B, Linia Gięcia',
        CURRENT_DATE - INTERVAL '150 days',
        CURRENT_DATE + INTERVAL '20 days',
        CURRENT_DATE + INTERVAL '215 days',
        14890
    );

-- ============================================================================
-- 6. ZGŁOSZENIA AWARII (10 TICKETÓW)
-- ============================================================================

INSERT INTO tickets (
    asset_id, reported_by, assigned_to,
    title, description, priority, status, ai_suggestion, scheduled_for, created_at, closed_at
) VALUES
    (
        (SELECT id FROM assets WHERE serial_number = 'TURB-2024-9004'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Przegrzanie przekładni głównej i spadek ciśnienia oleju',
        'Niski poziom oleju w przekładni głównej, gwałtowny wzrost temperatury łożyska do 68.4°C oraz podwyższone drgania (2.8 mm/s).',
        'CRITICAL',
        'IN_PROGRESS',
        'Wykryto ryzyko zatarcia łożyska przekładni. Zalecana inspekcja uszczelniacza wału, wymiana filtra oleju oraz dolewka SynthGear 320.',
        CURRENT_TIMESTAMP + INTERVAL '4 hours',
        CURRENT_TIMESTAMP - INTERVAL '2 days',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'ELEV-8832-K3'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Zacinające się drzwi kabinowe na 3. piętrze',
        'Czujnik kurtyny świetlnej zgłasza okresowy błąd przy zamykaniu drzwi na 3. piętrze, winda przechodzi w tryb serwisowy.',
        'HIGH',
        'IN_PROGRESS',
        'Prawdopodobne zabrudzenie prowadnicy dolnej lub rozregulowanie enkodera napędu drzwi. Oczyścić próg i skalibrować napęd.',
        CURRENT_TIMESTAMP + INTERVAL '1 day',
        CURRENT_TIMESTAMP - INTERVAL '1 day',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'PRESS-BYS-1502'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Wyciek z rozdzielacza hydraulicznego osi Y1',
        'Zauważono sączenie oleju hydraulicznego przy bloku zaworowym osi Y1 podczas pracy pod pełnym obciążeniem.',
        'HIGH',
        'OPEN',
        'Sprawdzić stan oringów na zaworze proporcjonalnym Rexroth oraz dokręcenie króćców wysokociśnieniowych.',
        CURRENT_TIMESTAMP + INTERVAL '2 days',
        CURRENT_TIMESTAMP - INTERVAL '12 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'COMP-AC-7599'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Komunikat o zbliżającej się wymianie separatora oleju',
        'Sterownik Elektronikon wyświetla ostrzeżenie o wzroście różnicy ciśnień na separatorze oleju powyżej 0.8 bar.',
        'MEDIUM',
        'OPEN',
        NULL,
        CURRENT_TIMESTAMP + INTERVAL '3 days',
        CURRENT_TIMESTAMP - INTERVAL '6 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'CNC-DMG-1104'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        NULL,
        'Okresowy alarm chłodzenia wrzeciona',
        'Po 4 godzinach ciągłej obróbki pojawia się ostrzeżenie o temperaturze chłodziwa wrzeciona.',
        'LOW',
        'OPEN',
        NULL,
        NULL,
        CURRENT_TIMESTAMP - INTERVAL '3 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'TURB-2024-9007'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Kalibracja anemometru ultradźwiękowego',
        'Rozbieżność wskazań kierunku wiatru względem sąsiedniej turbiny #04 o ok. 12 stopni.',
        'LOW',
        'RESOLVED',
        'Wykonano ponowne zerowanie czujnika względem osi gondoli i zweryfikowano przewód sygnałowy.',
        CURRENT_TIMESTAMP - INTERVAL '3 days',
        CURRENT_TIMESTAMP - INTERVAL '5 days',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'ELEV-4410-OT'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Wymiana oświetlenia awaryjnego w kabinie',
        'Akumulator lampy awaryjnej nie utrzymuje wymaganego czasu podtrzymania 1h podczas testu.',
        'MEDIUM',
        'CLOSED',
        'Wymieniono pakiet akumulatorowy NiMH 12V i przeprowadzono test obciążeniowy.',
        CURRENT_TIMESTAMP - INTERVAL '10 days',
        CURRENT_TIMESTAMP - INTERVAL '12 days',
        CURRENT_TIMESTAMP - INTERVAL '9 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'TANK-AP-2008'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Przegląd zaworu bezpieczeństwa i odwadniacza kondensatu',
        'Rutynowa kontrola szczelności automatycznego spustu kondensatu oraz manometru kontrolnego.',
        'LOW',
        'CLOSED',
        'Oczyszczono zawór spustowy, manometr wskazuje poprawnie.',
        CURRENT_TIMESTAMP - INTERVAL '15 days',
        CURRENT_TIMESTAMP - INTERVAL '18 days',
        CURRENT_TIMESTAMP - INTERVAL '14 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'COMP-AC-7599'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Czyszczenie chłodnicy końcowej sprężonego powietrza',
        'Zanieczyszczone lamele chłodnicy po sezonie letnim powodowały podniesioną temperaturę na wylocie.',
        'MEDIUM',
        'CLOSED',
        'Przedmuchano chłodnicę sprężonym powietrzem, temperatura spadła o 9°C.',
        CURRENT_TIMESTAMP - INTERVAL '22 days',
        CURRENT_TIMESTAMP - INTERVAL '25 days',
        CURRENT_TIMESTAMP - INTERVAL '21 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'CNC-DMG-1104'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Wymiana zgarniacza osłony teleskopowej osi X',
        'Uszkodzona listwa zgarniająca wióry na prowadnicy osi X.',
        'HIGH',
        'RESOLVED',
        'Zamontowano nową listwę zgarniającą DMG-X1100 i przesmarowano prowadnice.',
        CURRENT_TIMESTAMP - INTERVAL '2 days',
        CURRENT_TIMESTAMP - INTERVAL '4 days',
        NULL
    );

-- ============================================================================
-- 7. HISTORIA ZGŁOSZEŃ (POCZĄTKOWE WPISY)
-- ============================================================================

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note)
SELECT
    t.id,
    t.reported_by,
    NULL,
    'OPEN',
    'Rejestracja zgłoszenia w systemie AssetFix AI'
FROM tickets t;

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note)
SELECT
    t.id,
    COALESCE(t.assigned_to, t.reported_by),
    'OPEN',
    t.status,
    'Zmiana statusu podczas obsługi serwisowej'
FROM tickets t
WHERE t.status <> 'OPEN';

-- ============================================================================
-- 8. PRZYKŁADOWY LOG PRZYPOMNIEŃ CRON
-- ============================================================================

INSERT INTO reminder_logs (asset_id, reminder_for_date, recipient_email, status, error_message)
VALUES (
    (SELECT id FROM assets WHERE serial_number = 'TURB-2024-9007'),
    CURRENT_DATE + INTERVAL '45 days',
    'admin@assetfix.ai',
    'SENT',
    NULL
);
