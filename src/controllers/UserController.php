<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

final class UserController extends AppController
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    // Trasa zwykła: /admin/users (Panel zarządzania zespołem i uprawnieniami)
    public function index(): void
    {
        $this->render('users', [
            'pageTitle' => 'Zarządzanie Zespołem i Uprawnieniami',
            'users' => $this->userRepository->findAll(),
            'stats' => $this->userRepository->getStats(),
        ]);
    }

    // Trasa zwykła: /profile (Karta profilowa serwisanta i uprawnienia)
    public function profile(): void
    {
        $user = $this->userRepository->findDefaultTechnician();

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
