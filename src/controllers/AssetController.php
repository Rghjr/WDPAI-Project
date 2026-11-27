<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;

final class AssetController extends AppController
{
    // Trasa zwykła: /assets (Rejestr parku maszynowego EAM)
    public function index(): void
    {
        $assetRepo = new AssetRepository();

        $category = isset($_GET['category']) && is_string($_GET['category']) ? $_GET['category'] : null;
        $status = isset($_GET['status']) && is_string($_GET['status']) ? strtoupper($_GET['status']) : null;
        $search = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : null;

        $this->render('assets', [
            'pageTitle' => 'EAM – Park Maszynowy i Urządzenia',
            'assets' => $assetRepo->findAll($category, $status, $search),
            'categories' => $assetRepo->findCategories(),
            'stats' => $assetRepo->getStats(),
            'activeCategory' => $category ?? '',
            'searchQuery' => $search ?? '',
        ]);
    }

    // Trasa z parametrem: /assets/{id} (Paszport techniczny maszyny)
    public function show(int $id): void
    {
        if ($id <= 0) {
            http_response_code(400);
            $this->render('not-found', ['pageTitle' => 'Nieprawidłowe ID maszyny']);
            return;
        }

        $assetRepo = new AssetRepository();
        $asset = $assetRepo->findById($id);

        if ($asset === null) {
            http_response_code(404);
            $this->render('not-found', ['pageTitle' => 'Nie znaleziono maszyny']);
            return;
        }

        $this->render('asset', [
            'pageTitle' => 'Paszport EAM – ' . $asset['name'],
            'asset' => $asset,
        ]);
    }

    // Trasa zwykła: /assets/add
    public function add(): void
    {
        $assetRepo = new AssetRepository();

        $this->render('add-asset', [
            'pageTitle' => 'Rejestracja Nowej Maszyny w EAM',
            'categories' => $assetRepo->findCategories(),
            'clients' => $assetRepo->findClientLocations(),
        ]);
    }
}
