<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;

final class DispatchController extends AppController
{
    // Trasa zwykła: /map (Centrum Dyspozytorskie i Mapa Operacyjna)
    public function map(): void
    {
        $assetRepo = new AssetRepository();
        $userRepo = new UserRepository();
        $ticketRepo = new TicketRepository();

        $this->render('map', [
            'pageTitle' => 'Centrum Dyspozytorskie – Mapa Operacyjna GIS',
            'locations' => $assetRepo->findClientLocations(),
            'userStats' => $userRepo->getStats(),
            'ticketStats' => $ticketRepo->getStats(),
        ]);
    }

    // Trasa zwykła: /schedule (Harmonogram i Dyspozycja Techników + Dozór UDT)
    public function schedule(): void
    {
        $activeTab = isset($_GET['tab']) && is_string($_GET['tab']) ? $_GET['tab'] : 'dispatch';

        $assetRepo = new AssetRepository();
        $ticketRepo = new TicketRepository();

        $this->render('schedule', [
            'pageTitle' => 'Harmonogram i Dyspozycja Zespołu UR',
            'activeTab' => $activeTab,
            'upcomingInspections' => $assetRepo->findUpcomingInspections(90),
            'scheduledTickets' => $ticketRepo->findAll(null, null, null, 'today'),
            'assetStats' => $assetRepo->getStats(),
            'ticketStats' => $ticketRepo->getStats(),
        ]);
    }
}
