<?php

declare(strict_types=1);

namespace App\Controller;

final class UserController extends AppController
{
    // Trasa zwykła: /admin/users (Panel zarządzania zespołem i uprawnieniami)
    public function index(): void
    {
        $this->render('users', [
            'pageTitle' => 'Zarządzanie Zespołem i Uprawnieniami',
            'totalUsers' => 12,
            'activeTechnicians' => 8,
            'onDutyTechnicians' => 3,
            'avgSlaResponseMinutes' => 38,
        ]);
    }

    // Trasa zwykła: /profile (Karta profilowa serwisanta i uprawnienia)
    public function profile(): void
    {
        $this->render('profile', [
            'pageTitle' => 'Karta Serwisanta – Piotr Kowalski',
            'employeeId' => 'TECH-042',
            'name' => 'Piotr Kowalski',
            'role' => 'TECHNICIAN',
            'roleTitle' => 'Główny Technik Serwisu (Lead Field Engineer)',
            'email' => 'piotr.kowalski@assetfix.ai',
            'phone' => '+48 601 234 567',
            'baseLocation' => 'Poznań (Region Wielkopolska)',
            'hireDate' => '2022-03-01',
            'completedTicketsCount' => 142,
            'firstTimeFixRate' => 94.2,
            'avgRepairHours' => 1.8,
            'slaComplianceRate' => 99.1,
        ]);
    }

    // Trasa zwykła: /login
    public function login(): void
    {
        $this->render('login', [
            'pageTitle' => 'Logowanie do systemu AssetFix AI',
        ]);
    }
}
