<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;

final class DefaultController extends AppController
{
    public function index(): void
    {
        $ticketRepo = new TicketRepository();
        $assetRepo = new AssetRepository();
        $userRepo = new UserRepository();

        $this->render('home', [
            'pageTitle' => 'Pulpit Operacyjny | AssetFix AI',
            'currentUser' => $userRepo->findDefaultTechnician(),
            'ticketStats' => $ticketRepo->getStats(),
            'assetStats' => $assetRepo->getStats(),
            'activeTickets' => $ticketRepo->findLatestActive(3),
            'criticalIncident' => $ticketRepo->findLatestCriticalIncident(),
        ]);
    }

    public function notFound(): void
    {
        $this->render('not-found', [
            'pageTitle' => 'Nie znaleziono strony',
        ]);
    }
}
