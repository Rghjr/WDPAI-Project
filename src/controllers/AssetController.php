<?php

declare(strict_types=1);

namespace App\Controller;

final class AssetController extends AppController
{
    // Trasa zwykła: /assets (Rejestr parku maszynowego EAM)
    public function index(): void
    {
        $this->render('assets', [
            'pageTitle' => 'EAM – Park Maszynowy i Urządzenia',
            'totalAssets' => 12,
            'operationalCount' => 10,
            'inRepairCount' => 2,
        ]);
    }

    // Trasa z parametrem: /assets/{id} (Paszport techniczny maszyny)
    public function show(int $id): void
    {
        $mockAssets = [
            1 => [
                'name' => 'Turbina Wiatrowa V90 #04',
                'serialNumber' => 'TURB-2024-9004',
                'category' => 'OZE / Turbiny Wiatrowe',
                'status' => 'AWARIA',
                'statusLabel' => 'W trakcie awarii / Zgłoszenie #1',
                'clientName' => 'Polenergia Farma Margonin S.A.',
                'location' => 'Margonin, Wieża B-12 (Współrzędne: 52.9734° N, 16.9921° E)',
                'manufacturer' => 'Vestas Wind Systems A/S',
                'model' => 'V90-2.0 MW Pitch Controlled',
                'productionYear' => 2021,
                'commissioningDate' => '2021-09-14',
                'udtNumber' => 'UDT-POZ-7712/2021',
                'lastInspectionDate' => '2026-01-15',
                'nextInspectionDate' => '2026-11-20',
                'udtDecisionValidUntil' => '2027-01-15',
                'operatingHours' => 18420,
                'powerRating' => '2 000 kW (2.0 MW)',
                'operatingVoltage' => '690 V / 50 Hz',
                'assignedTechnician' => 'Piotr Kowalski (Główny Technik)',
                'tempSensor' => 68.4,
                'vibrationSensor' => 2.8,
                'pressureSensor' => 14.2,
                'activeTicketId' => 1,
            ],
            2 => [
                'name' => 'Winda Osobowa KONE B3',
                'serialNumber' => 'ELEV-8832-K3',
                'category' => 'Dźwigi i Windy Osobowe',
                'status' => 'W_NAPRAWIE',
                'statusLabel' => 'W trakcie naprawy okresowej',
                'clientName' => 'Biurowiec Pixel Poznań Sp. z o.o.',
                'location' => 'Poznań, ul. Grunwaldzka 182, Szyb Pasażerski B3',
                'manufacturer' => 'KONE Corporation',
                'model' => 'MonoSpace 500 DX',
                'productionYear' => 2022,
                'commissioningDate' => '2022-04-10',
                'udtNumber' => 'UDT-POZ-ELEV-9941',
                'lastInspectionDate' => '2026-05-10',
                'nextInspectionDate' => '2026-11-15',
                'udtDecisionValidUntil' => '2027-05-10',
                'operatingHours' => 9640,
                'powerRating' => '11 kW',
                'operatingVoltage' => '400 V 3-fazowy',
                'assignedTechnician' => 'Piotr Kowalski (Główny Technik)',
                'tempSensor' => 42.1,
                'vibrationSensor' => 0.9,
                'pressureSensor' => 8.5,
                'activeTicketId' => 2,
            ],
            3 => [
                'name' => 'Sprężarka Śrubowa Atlas Copco GA 75',
                'serialNumber' => 'COMP-AC-7599',
                'category' => 'Sprężarki Przemysłowe',
                'status' => 'OPERACYJNA',
                'statusLabel' => 'Stan operacyjny prawidłowy',
                'clientName' => 'Solaris Bus & Coach Sp. z o.o.',
                'location' => 'Bolechowo, Hala Montażowa H-4, Sprężarkownia Centralna',
                'manufacturer' => 'Atlas Copco Airpower',
                'model' => 'GA 75 VSD+ FF',
                'productionYear' => 2023,
                'commissioningDate' => '2023-02-18',
                'udtNumber' => 'UDT-POZ-ZB-3129',
                'lastInspectionDate' => '2026-02-18',
                'nextInspectionDate' => '2027-02-18',
                'udtDecisionValidUntil' => '2028-02-18',
                'operatingHours' => 12150,
                'powerRating' => '75 kW',
                'operatingVoltage' => '400 V / 50 Hz',
                'assignedTechnician' => 'Marek Nowak (Technik Serwisu)',
                'tempSensor' => 54.0,
                'vibrationSensor' => 1.2,
                'pressureSensor' => 9.8,
                'activeTicketId' => null,
            ],
        ];

        $asset = $mockAssets[$id] ?? [
            'name' => 'Urządzenie Przemysłowe #' . $id,
            'serialNumber' => 'IND-2024-00' . $id,
            'category' => 'Urządzenia i Maszyny Produkcyjne',
            'status' => 'OPERACYJNA',
            'statusLabel' => 'Stan techniczny zadowalający',
            'clientName' => 'Zakład Produkcyjny Wielkopolska',
            'location' => 'Poznań, Sektor Główny',
            'manufacturer' => 'Industrial Tech Solutions',
            'model' => 'Standard Edition Pro',
            'productionYear' => 2023,
            'commissioningDate' => '2023-01-01',
            'udtNumber' => 'UDT-POZ-' . $id . '000',
            'lastInspectionDate' => '2026-01-01',
            'nextInspectionDate' => '2026-12-01',
            'udtDecisionValidUntil' => '2027-01-01',
            'operatingHours' => 5000 + ($id * 250),
            'powerRating' => '45 kW',
            'operatingVoltage' => '400 V',
            'assignedTechnician' => 'Piotr Kowalski',
            'tempSensor' => 51.5,
            'vibrationSensor' => 1.4,
            'pressureSensor' => 6.2,
            'activeTicketId' => null,
        ];

        $this->render('asset', [
            'pageTitle' => 'Paszport Maszyny: ' . $asset['name'],
            'assetId' => $id,
            'asset' => $asset,
        ]);
    }

    // Trasa zwykła: /assets/add (Rejestracja nowej maszyny do EAM)
    public function add(): void
    {
        $this->render('add-asset', [
            'pageTitle' => 'Rejestracja Nowego Urządzenia w Parku Maszynowym',
        ]);
    }

    // Trasa zwykła: /maintenance (Harmonogram przeglądów okresowych i UDT)
    public function maintenance(): void
    {
        $this->render('maintenance', [
            'pageTitle' => 'Harmonogram Przeglądów i Dozoru Technicznego (EAM)',
            'dueInSevenDays' => 2,
            'dueThisMonth' => 5,
            'completedThisQuarter' => 28,
            'udtComplianceRate' => 98.5,
        ]);
    }

    // Trasa zwykła: /login (wsteczna kompatybilność, przekierowanie do widoku logowania)
    public function login(): void
    {
        $this->render('login', [
            'pageTitle' => 'Logowanie do systemu AssetFix AI',
        ]);
    }
}
