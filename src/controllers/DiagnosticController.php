<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;

final class DiagnosticController extends AppController
{
    // Trasa zwykła: /diagnostics (Centrum Predykcyjnej Analityki i Smart Diagnosis AI)
    public function index(): void
    {
        $ticketRepo = new TicketRepository();
        $assetRepo = new AssetRepository();

        $this->render('diagnostics', [
            'pageTitle' => 'Centrum Analityki Predykcyjnej – Smart Diagnosis AI (Ollama)',
            'criticalIncident' => $ticketRepo->findLatestCriticalIncident(),
            'aiDiagnosedTickets' => $ticketRepo->findAiDiagnosed(8),
            'ticketStats' => $ticketRepo->getStats(),
            'assetStats' => $assetRepo->getStats(),
        ]);
    }
}
