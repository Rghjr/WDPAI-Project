<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;

final class DispatchController extends AppController
{
    public function __construct(
        private AssetRepository $assetRepository,
        private UserRepository $userRepository,
        private TicketRepository $ticketRepository,
    ) {
    }

    // Trasa zwykła: /map (Centrum Dyspozytorskie i Mapa Operacyjna)
    public function map(): void
    {
        $this->render('map', [
            'pageTitle' => 'Centrum Dyspozytorskie – Mapa Operacyjna GIS',
            'locations' => $this->assetRepository->findClientLocations(),
            'userStats' => $this->userRepository->getStats(),
            'ticketStats' => $this->ticketRepository->getStats(),
        ]);
    }

    // Trasa zwykła: /schedule (Harmonogram i Dyspozycja Techników + Dozór UDT)
    public function schedule(): void
    {
        $activeTab = isset($_GET['tab']) && is_string($_GET['tab']) ? $_GET['tab'] : 'dispatch';

        $this->render('schedule', [
            'pageTitle' => 'Harmonogram i Dyspozycja Zespołu UR',
            'activeTab' => $activeTab,
            'upcomingInspections' => $this->assetRepository->findUpcomingInspections(90),
            'scheduledTickets' => $this->ticketRepository->findAll(null, null, null, 'today'),
            'assetStats' => $this->assetRepository->getStats(),
            'ticketStats' => $this->ticketRepository->getStats(),
        ]);
    }
}
