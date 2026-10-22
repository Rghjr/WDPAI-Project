<?php

declare(strict_types=1);

namespace App\Controller;

final class AssetController extends AppController
{
    // Trasa zwykła: /assets
    public function index(): void
    {
        $this->render('assets', [
            'pageTitle' => 'EAM – Park Maszynowy i Urządzenia',
            'totalAssets' => 12,
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