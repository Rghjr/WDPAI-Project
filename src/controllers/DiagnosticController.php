<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;

final class DiagnosticController extends AppController
{
    public function __construct(
        private TicketRepository $ticketRepository,
        private AssetRepository $assetRepository,
    ) {
    }

    // Trasa zwykła: /diagnostics (Centrum Predykcyjnej Analityki i Smart Diagnosis AI)
    public function index(): void
    {
        $this->render('diagnostics', [
            'pageTitle' => 'Centrum Analityki Predykcyjnej – Smart Diagnosis AI (Ollama)',
            'criticalIncident' => $this->ticketRepository->findLatestCriticalIncident(),
            'aiDiagnosedTickets' => $this->ticketRepository->findAiDiagnosed(8),
            'ticketStats' => $this->ticketRepository->getStats(),
            'assetStats' => $this->assetRepository->getStats(),
        ]);
    }
}
