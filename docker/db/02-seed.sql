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
-- 2. UŻYTKOWNICY (2 ADMIN, 6 TECHNICIAN)
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
        (SELECT id FROM roles WHERE name = 'ADMIN'),
        'tomasz.kaczmarek@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Tomasz',
        'Kaczmarek',
        'MGR-002',
        '+48 600 100 205',
        'Kraków (Oddział Południe)',
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
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'lukasz.wojcik@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Łukasz',
        'Wójcik',
        'TECH-045',
        '+48 604 567 890',
        'Wrocław (Region Dolny Śląsk)',
        TRUE
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'karolina.mazur@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Karolina',
        'Mazur',
        'TECH-046',
        '+48 605 678 901',
        'Gdańsk (Region Pomorze)',
        TRUE
    ),
    (
        (SELECT id FROM roles WHERE name = 'TECHNICIAN'),
        'dawid.lewandowski@assetfix.ai',
        crypt('AssetFix2026!', gen_salt('bf', 10)),
        'Dawid',
        'Lewandowski',
        'TECH-047',
        '+48 606 789 012',
        'Łódź (Region Centralny)',
        FALSE
    );

-- ============================================================================
-- 3. KLIENCI (8 LOKALIZACJI Z WSPÓŁRZĘDNYMI GIS)
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
    ),
    (
        'LG Energy Solution Wrocław Sp. z o.o.',
        'ul. LG 1, Biskupice Podgórne',
        'Wrocław',
        'facility@lges-demo.pl',
        '+48 71 733 90 00',
        51.021500,
        16.924800
    ),
    (
        'Centrum Logistyczne Panattoni Kraków',
        'ul. Magazynowa 8',
        'Kraków',
        'techniczny@panattoni-demo.pl',
        '+48 12 410 55 30',
        50.039200,
        20.068100
    ),
    (
        'Port Kontenerowy Baltic Hub Gdańsk',
        'ul. Kontenerowa 7',
        'Gdańsk',
        'utrzymanie@baltichub-demo.pl',
        '+48 58 737 60 00',
        54.395800,
        18.718600
    ),
    (
        'Fabryka Opakowań FlexPack Łódź',
        'ul. Techniczna 22',
        'Łódź',
        'utrzymanie@flexpack-demo.pl',
        '+48 42 640 12 80',
        51.745300,
        19.512400
    );

-- ============================================================================
-- 4. KATEGORIE MASZYN (6 KATEGORII)
-- ============================================================================

INSERT INTO asset_categories (name, description) VALUES
    ('OZE / Turbiny Wiatrowe', 'Turbiny wiatrowe, przekładnie główne oraz systemy pitch/yaw'),
    ('Dźwigi i Windy Osobowe', 'Dźwigi osobowe i towarowe podlegające dozorowi UDT'),
    ('Sprężarki Przemysłowe', 'Sprężarki śrubowe i tłokowe oraz zbiorniki ciśnieniowe'),
    ('Maszyny Produkcyjne CNC', 'Centra obróbcze CNC, tokarki i prasy hydrauliczne'),
    ('Systemy HVAC i Chłodnictwo', 'Chillery przemysłowe, centrale wentylacyjne i pompy ciepła'),
    ('Wózki Widłowe i UTB', 'Wózki wysokiego składowania, suwnice i podesty ruchome UDT');

-- ============================================================================
-- 5. PARK MASZYNOWY (15 MASZYN, RÓŻNE TERMINY PRZEGLĄDÓW UDT/OKRESOWYCH)
-- ============================================================================

INSERT INTO assets (
    client_id, category_id, assigned_technician_id,
    name, serial_number, status, manufacturer, model, production_year,
    udt_number, location_details, last_inspection_at, next_inspection_at,
    udt_valid_until, operating_hours
) VALUES
    (
        (SELECT id FROM clients WHERE name = 'Polenergia Farma Margonin S.A.'),
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
        (SELECT id FROM clients WHERE name = 'Biurowiec Pixel Poznań Sp. z o.o.'),
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
        (SELECT id FROM clients WHERE name = 'Solaris Bus & Coach Sp. z o.o.'),
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
        (SELECT id FROM clients WHERE name = 'Zakład Produkcyjny Wielkopolska Sp. z o.o.'),
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
        (SELECT id FROM clients WHERE name = 'Polenergia Farma Margonin S.A.'),
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
        (SELECT id FROM clients WHERE name = 'Biurowiec Pixel Poznań Sp. z o.o.'),
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
        (SELECT id FROM clients WHERE name = 'Solaris Bus & Coach Sp. z o.o.'),
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
        (SELECT id FROM clients WHERE name = 'Zakład Produkcyjny Wielkopolska Sp. z o.o.'),
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
    ),
    (
        (SELECT id FROM clients WHERE name = 'LG Energy Solution Wrocław Sp. z o.o.'),
        (SELECT id FROM asset_categories WHERE name = 'Systemy HVAC i Chłodnictwo'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        'Chiller Trane Sintesis RTAF 350',
        'HVAC-TRN-3501',
        'IN_REPAIR',
        'Trane',
        'Sintesis RTAF 350',
        2022,
        'UDT-WRO-CH-2201',
        'Dach Hali Produkcyjnej C2',
        CURRENT_DATE - INTERVAL '175 days',
        CURRENT_DATE + INTERVAL '4 days',
        CURRENT_DATE + INTERVAL '190 days',
        16340
    ),
    (
        (SELECT id FROM clients WHERE name = 'LG Energy Solution Wrocław Sp. z o.o.'),
        (SELECT id FROM asset_categories WHERE name = 'Maszyny Produkcyjne CNC'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        'Tokarka CNC Mazak Quick Turn 250',
        'CNC-MZK-2508',
        'OPERATIONAL',
        'Yamazaki Mazak',
        'Quick Turn 250MSY',
        2023,
        NULL,
        'Hala Narzędziowni N-1',
        CURRENT_DATE - INTERVAL '45 days',
        CURRENT_DATE + INTERVAL '135 days',
        NULL,
        4210
    ),
    (
        (SELECT id FROM clients WHERE name = 'Centrum Logistyczne Panattoni Kraków'),
        (SELECT id FROM asset_categories WHERE name = 'Wózki Widłowe i UTB'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Wózek Systemowy Jungheinrich EKX 516',
        'UTB-JGH-5160',
        'OPERATIONAL',
        'Jungheinrich AG',
        'EKX 516k',
        2022,
        'UDT-KRK-UTB-8812',
        'Strefa Wysokiego Składowania, Aleja 4',
        CURRENT_DATE - INTERVAL '368 days',
        CURRENT_DATE - INTERVAL '3 days',
        CURRENT_DATE + INTERVAL '10 days',
        6890
    ),
    (
        (SELECT id FROM clients WHERE name = 'Centrum Logistyczne Panattoni Kraków'),
        (SELECT id FROM asset_categories WHERE name = 'Systemy HVAC i Chłodnictwo'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Centrala Wentylacyjna VTS Ventus N-Type',
        'HVAC-VTS-9022',
        'OPERATIONAL',
        'VTS Group',
        'VS 150 R-F-H',
        2021,
        NULL,
        'Maszynownia Dachowa Sektor A',
        CURRENT_DATE - INTERVAL '95 days',
        CURRENT_DATE + INTERVAL '85 days',
        NULL,
        13400
    ),
    (
        (SELECT id FROM clients WHERE name = 'Port Kontenerowy Baltic Hub Gdańsk'),
        (SELECT id FROM asset_categories WHERE name = 'Wózki Widłowe i UTB'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        'Suwnica Bramowa Konecranes RTG #11',
        'UTB-KNC-1109',
        'OUT_OF_SERVICE',
        'Konecranes',
        'Boxhunter RTG 16-wheel',
        2020,
        'UDT-GDA-SUW-4011',
        'Nabrzeże T2, Sektor Kontenerowy B',
        CURRENT_DATE - INTERVAL '210 days',
        CURRENT_DATE + INTERVAL '6 days',
        CURRENT_DATE + INTERVAL '155 days',
        21500
    ),
    (
        (SELECT id FROM clients WHERE name = 'Port Kontenerowy Baltic Hub Gdańsk'),
        (SELECT id FROM asset_categories WHERE name = 'Sprężarki Przemysłowe'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        'Sprężarka Kaeser CSD 125',
        'COMP-KSR-1254',
        'OPERATIONAL',
        'Kaeser Kompressoren',
        'CSD 125 SFC',
        2024,
        'UDT-GDA-ZB-5102',
        'Warsztat Główny, Stanowisko 2',
        CURRENT_DATE - INTERVAL '30 days',
        CURRENT_DATE + INTERVAL '150 days',
        CURRENT_DATE + INTERVAL '515 days',
        2850
    ),
    (
        (SELECT id FROM clients WHERE name = 'Fabryka Opakowań FlexPack Łódź'),
        (SELECT id FROM asset_categories WHERE name = 'Maszyny Produkcyjne CNC'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Wykrawarka Rewolwerowa Trumpf TruPunch 3000',
        'CNC-TRP-3005',
        'OPERATIONAL',
        'TRUMPF GmbH',
        'TruPunch 3000 S11',
        2021,
        NULL,
        'Hala Produkcyjna 2, Linia A',
        CURRENT_DATE - INTERVAL '140 days',
        CURRENT_DATE + INTERVAL '40 days',
        NULL,
        10320
    );

-- ============================================================================
-- 6. ZGŁOSZENIA AWARII (20 TICKETÓW)
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
        'Wymienić wkład separatora oraz skontrolować zawór zwrotny odolejacza.',
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
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'UTB-KNC-1109'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        'Awaria falownika napędu jazdy suwnicy RTG #11',
        'Suwnica zatrzymała się na torze jazdy z kodem błędu F0042 (przeciążenie obwodu DC-link).',
        'CRITICAL',
        'IN_PROGRESS',
        'Sprawdzić rezystor hamowania oraz moduł IGBT falownika głównego; zmierzyć izolację silnika jazdy.',
        CURRENT_TIMESTAMP + INTERVAL '2 hours',
        CURRENT_TIMESTAMP - INTERVAL '8 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'HVAC-TRN-3501'),
        (SELECT id FROM users WHERE email = 'tomasz.kaczmarek@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        'Spadek wydajności obiegu chłodniczego B w chillerze',
        'Różnica temperatur na parowniku spadła poniżej 2.5 K, podejrzenie nieszczelności na zaworze rozprężnym EEV.',
        'HIGH',
        'IN_PROGRESS',
        'Wykonać próbę azotową układu B, sprawdzić przegrzanie na zaworze EEV oraz odczyt przetwornika ciśnienia ssania.',
        CURRENT_TIMESTAMP + INTERVAL '6 hours',
        CURRENT_TIMESTAMP - INTERVAL '1 day',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'UTB-JGH-5160'),
        (SELECT id FROM users WHERE email = 'tomasz.kaczmarek@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'Przeterminowany przegląd okresowy UDT wózka EKX 516',
        'Wymagane pilne wykonanie przeglądu konserwatorskiego UDT oraz testu hamulca bezpieczeństwa.',
        'HIGH',
        'OPEN',
        'Przeprowadzić pełną checklistę UDT dla wózków systemowych oraz wpis do dziennika konserwacji.',
        CURRENT_TIMESTAMP + INTERVAL '1 day',
        CURRENT_TIMESTAMP - INTERVAL '4 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'CNC-MZK-2508'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        'Luz osiowy na głowicy rewolwerowej',
        'Podczas ciężkiego toczenia zgrubnego słyszalne stuki przy indeksowaniu narzędzia nr 6.',
        'MEDIUM',
        'OPEN',
        'Skontrolować docisk sprzęgła zębatego Hirtha oraz ciśnienie odblokowania tarczy rewolwerowej.',
        CURRENT_TIMESTAMP + INTERVAL '4 days',
        CURRENT_TIMESTAMP - INTERVAL '10 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'HVAC-VTS-9022'),
        (SELECT id FROM users WHERE email = 'tomasz.kaczmarek@assetfix.ai'),
        NULL,
        'Głośna praca wentylatora nawiewnego w centrali',
        'Wibracje obudowy powyżej normy przy 80% wydajności falownika.',
        'MEDIUM',
        'OPEN',
        NULL,
        NULL,
        CURRENT_TIMESTAMP - INTERVAL '5 hours',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'COMP-KSR-1254'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        'Wymiana filtra powietrza dolotowego po 2500 h',
        'Planowa wymiana filtra powietrza i kontrola naciągu paska napędowego.',
        'LOW',
        'CLOSED',
        'Wymieniono filtr Kaeser 6.4163.0, parametry pracy w normie.',
        CURRENT_TIMESTAMP - INTERVAL '7 days',
        CURRENT_TIMESTAMP - INTERVAL '8 days',
        CURRENT_TIMESTAMP - INTERVAL '6 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'CNC-TRP-3005'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'marek.nowak@assetfix.ai'),
        'Błąd czujnika krańcowego stołu szczotkowego',
        'Maszyna nie zezwala na start cyklu automatycznego po załadunku arkusza blachy.',
        'HIGH',
        'RESOLVED',
        'Wymieniono indukcyjny czujnik zbliżeniowy Sick IME12 oraz wyregulowano odległość detekcji.',
        CURRENT_TIMESTAMP - INTERVAL '1 day',
        CURRENT_TIMESTAMP - INTERVAL '2 days',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'TURB-2024-9004'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Kontrola momentu dokręcenia śrub piasty wirnika',
        'Okresowa weryfikacja kluczem dynamometrycznym po pierwszym roku eksploatacji.',
        'MEDIUM',
        'CLOSED',
        'Wszystkie śruby w specyfikacji 1450 Nm, brak poluzowań.',
        CURRENT_TIMESTAMP - INTERVAL '30 days',
        CURRENT_TIMESTAMP - INTERVAL '33 days',
        CURRENT_TIMESTAMP - INTERVAL '29 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'ELEV-8832-K3'),
        (SELECT id FROM users WHERE email = 'admin@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'Test łączności alarmowej GSM w kabinie',
        'Comiesięczny test połączenia głosowego z centralą alarmową 24/7.',
        'LOW',
        'CLOSED',
        'Połączenie zestawione poprawnie, jakość sygnału 85%.',
        CURRENT_TIMESTAMP - INTERVAL '19 days',
        CURRENT_TIMESTAMP - INTERVAL '20 days',
        CURRENT_TIMESTAMP - INTERVAL '19 days'
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'HVAC-TRN-3501'),
        (SELECT id FROM users WHERE email = 'tomasz.kaczmarek@assetfix.ai'),
        (SELECT id FROM users WHERE email = 'lukasz.wojcik@assetfix.ai'),
        'Czyszczenie skraplacza mikrokanałowego przed sezonem',
        'Usunięcie pyłu i osadów z wymiennika ciepła przy użyciu chemii niskopieniącej.',
        'LOW',
        'CLOSED',
        'Wymiennik umyty, spadek ciśnienia skraplania o 1.4 bar.',
        CURRENT_TIMESTAMP - INTERVAL '40 days',
        CURRENT_TIMESTAMP - INTERVAL '42 days',
        CURRENT_TIMESTAMP - INTERVAL '39 days'
    );

-- ============================================================================
-- 7. HISTORIA ZGŁOSZEŃ
-- ============================================================================

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note, created_at)
SELECT
    t.id,
    t.reported_by,
    NULL,
    'OPEN',
    'Rejestracja zgłoszenia w systemie AssetFix AI',
    t.created_at
FROM tickets t;

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note, created_at)
SELECT
    t.id,
    COALESCE(t.assigned_to, t.reported_by),
    'OPEN',
    'IN_PROGRESS',
    'Technik przyjął zlecenie i rozpoczął diagnostykę w terenie',
    t.created_at + INTERVAL '2 hours'
FROM tickets t
WHERE t.status IN ('IN_PROGRESS', 'RESOLVED', 'CLOSED');

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note, created_at)
SELECT
    t.id,
    COALESCE(t.assigned_to, t.reported_by),
    'IN_PROGRESS',
    'RESOLVED',
    'Usterka usunięta, maszyna po testach ruchowych',
    t.created_at + INTERVAL '1 day'
FROM tickets t
WHERE t.status IN ('RESOLVED', 'CLOSED');

INSERT INTO ticket_history (ticket_id, changed_by, old_status, new_status, note, created_at)
SELECT
    t.id,
    t.reported_by,
    'RESOLVED',
    'CLOSED',
    'Protokół zaakceptowany, zgłoszenie zamknięte',
    COALESCE(t.closed_at, t.created_at + INTERVAL '2 days')
FROM tickets t
WHERE t.status = 'CLOSED';

-- ============================================================================
-- 8. PRZYKŁADOWE ZDJĘCIA DO ZGŁOSZEŃ (METADANE)
-- ============================================================================

INSERT INTO ticket_photos (ticket_id, uploaded_by, file_path, original_name, mime_type, size_bytes)
VALUES
    (
        (SELECT id FROM tickets WHERE title = 'Przegrzanie przekładni głównej i spadek ciśnienia oleju'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'uploads/tickets/1/demo-gearbox-temp.jpg',
        'termowizja-przekladnia-v90.jpg',
        'image/jpeg',
        482310
    ),
    (
        (SELECT id FROM tickets WHERE title = 'Przegrzanie przekładni głównej i spadek ciśnienia oleju'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'uploads/tickets/1/demo-oil-sightglass.png',
        'wziernik-poziom-oleju.png',
        'image/png',
        319420
    ),
    (
        (SELECT id FROM tickets WHERE title = 'Zacinające się drzwi kabinowe na 3. piętrze'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'uploads/tickets/2/demo-kone-door-track.jpg',
        'prowadnica-drzwi-pietro3.jpg',
        'image/jpeg',
        265100
    ),
    (
        (SELECT id FROM tickets WHERE title = 'Wyciek z rozdzielacza hydraulicznego osi Y1'),
        (SELECT id FROM users WHERE email = 'anna.zielinska@assetfix.ai'),
        'uploads/tickets/3/demo-hydraulic-manifold.jpg',
        'wyciek-rozdzielacz-y1.jpg',
        'image/jpeg',
        541880
    ),
    (
        (SELECT id FROM tickets WHERE title = 'Awaria falownika napędu jazdy suwnicy RTG #11'),
        (SELECT id FROM users WHERE email = 'karolina.mazur@assetfix.ai'),
        'uploads/tickets/11/demo-rtg-inverter-fault.webp',
        'panel-falownika-blad-f0042.webp',
        'image/webp',
        198450
    ),
    (
        (SELECT id FROM tickets WHERE title = 'Wymiana zgarniacza osłony teleskopowej osi X'),
        (SELECT id FROM users WHERE email = 'piotr.kowalski@assetfix.ai'),
        'uploads/tickets/10/demo-dmg-wiper-after.jpg',
        'oslona-os-x-po-wymianie.jpg',
        'image/jpeg',
        374900
    );

-- ============================================================================
-- 9. LOGI PRZYPOMNIEŃ CRON (SENT I FAILED)
-- ============================================================================

INSERT INTO reminder_logs (asset_id, reminder_for_date, recipient_email, status, error_message) VALUES
    (
        (SELECT id FROM assets WHERE serial_number = 'TURB-2024-9007'),
        CURRENT_DATE + INTERVAL '45 days',
        'admin@assetfix.ai',
        'SENT',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'ELEV-4410-OT'),
        CURRENT_DATE + INTERVAL '35 days',
        'admin@assetfix.ai',
        'SENT',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'CNC-TRP-3005'),
        CURRENT_DATE + INTERVAL '40 days',
        'admin@assetfix.ai',
        'SENT',
        NULL
    ),
    (
        (SELECT id FROM assets WHERE serial_number = 'UTB-JGH-5160'),
        CURRENT_DATE - INTERVAL '3 days',
        'tomasz.kaczmarek@assetfix.ai',
        'FAILED',
        'SMTP connection timeout (symulacja błędu dla testów logowania CRON)'
    );
