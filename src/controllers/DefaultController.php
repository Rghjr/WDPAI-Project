<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;

final class DefaultController extends AppController
{
    public function __construct(
        private TicketRepository $ticketRepository,
        private AssetRepository $assetRepository,
        private UserRepository $userRepository,
    ) {
    }

    public function index(): void
    {
        $this->render('home', [
            'pageTitle' => 'Pulpit Operacyjny | AssetFix AI',
            'currentUser' => $this->userRepository->findDefaultTechnician(),
            'ticketStats' => $this->ticketRepository->getStats(),
            'assetStats' => $this->assetRepository->getStats(),
            'activeTickets' => $this->ticketRepository->findLatestActive(3),
            'criticalIncident' => $this->ticketRepository->findLatestCriticalIncident(),
        ]);
    }

    public function notFound(): void
    {
        $this->render('not-found', [
            'pageTitle' => 'Nie znaleziono strony',
        ]);
    }
}
