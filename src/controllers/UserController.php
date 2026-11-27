<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

final class UserController extends AppController
{
    // Trasa zwykła: /admin/users (Panel zarządzania zespołem i uprawnieniami)
    public function index(): void
    {
        $userRepo = new UserRepository();

        $this->render('users', [
            'pageTitle' => 'Zarządzanie Zespołem i Uprawnieniami',
            'users' => $userRepo->findAll(),
            'stats' => $userRepo->getStats(),
        ]);
    }

    // Trasa zwykła: /profile (Karta profilowa serwisanta i uprawnienia)
    public function profile(): void
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findDefaultTechnician();

        $this->render('profile', [
            'pageTitle' => 'Karta Serwisanta – ' . ($user !== null ? $user->fullName() : 'Profil'),
            'user' => $user,
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
