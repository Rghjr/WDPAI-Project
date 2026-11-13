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
        $errors = [];
        $data = ['email' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['email'] = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Nieprawidłowy adres e‑mail.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Hasło musi mieć co najmniej 6 znaków.';
            }
            if (empty($errors)) {
                // Fake success – normally you would verify against DB
                // Successful login – redirect to main panel
                header('Location: /');
                exit;
            }
        }
        $this->render('login', [
            'pageTitle' => 'Logowanie do systemu AssetFix AI',
            'errors' => $errors,
            'data' => $data,
        ]);
    }

    // Trasa zwykła: /register (rejestracja)
    public function register(): void
    {
        // Simple handling without DB
        $errors = [];
        $data = ['username' => '', 'email' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['username'] = $_POST['username'] ?? '';
            $data['email'] = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            if (strlen($data['username']) < 3) {
                $errors[] = 'Nazwa użytkownika musi mieć co najmniej 3 znaki.';
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Nieprawidłowy adres e‑mail.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Hasło musi mieć co najmniej 6 znaków.';
            }
            if ($password !== $confirm) {
                $errors[] = 'Hasła nie są zgodne.';
            }
            if (empty($errors)) {
                // Fake success – normally you would save to DB
                $this->render('login', [
                    'pageTitle' => 'Logowanie do systemu AssetFix AI',
                    'success' => 'Rejestracja udana. Zaloguj się.'
                ]);
                return;
            }
        }
        $this->render('register', [
            'pageTitle' => 'Rejestracja',
            'errors' => $errors,
            'data' => $data,
        ]);
    }
}

