<?php

declare(strict_types=1);

namespace App\Controller;

final class DispatchController extends AppController
{
    // Trasa zwykła: /map (Centrum Dyspozytorskie i Mapa Operacyjna)
    public function map(): void
    {
        $this->render('map', [
            'pageTitle' => 'Centrum Dyspozytorskie – Mapa Operacyjna GIS',
            'activeTechsCount' => 14,
            'techsInTransit' => 10,
            'techsOnSite' => 4,
            'unassignedOrdersCount' => 1,
            'avgSlaResponseMinutes' => 28,
            'lastGpsSyncTime' => '14:02:18 (teraz)',
        ]);
    }

    // Trasa zwykła: /schedule (Harmonogram i Dyspozycja Techników + Dozór UDT)
    public function schedule(): void
    {
        $activeTab = $_GET['tab'] ?? 'dispatch';

        $this->render('schedule', [
            'pageTitle' => 'Harmonogram i Dyspozycja Zespołu UR',
            'activeTab' => $activeTab,
            'assignedTicketsCount' => 18,
            'totalPlannedTickets' => 20,
            'teamUtilizationPercent' => 88.4,
            'dueUdtCount' => 5,
            'dueUdtInSevenDays' => 2,
            'avgTravelMinutes' => 28,
            'currentWeek' => 'Tydzień 42 (14 – 20 Października 2026)',
        ]);
    }
}
