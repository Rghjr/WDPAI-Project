<?php

declare(strict_types=1);

namespace App\Controller;

final class DiagnosticController extends AppController
{
    // Trasa zwykła: /diagnostics (Centrum Predykcyjnej Analityki i Smart Diagnosis AI)
    public function index(): void
    {
        $this->render('diagnostics', [
            'pageTitle' => 'Centrum Analityki Predykcyjnej – Smart Diagnosis AI (Ollama)',
            'criticalIncident' => [
                'id' => 'WO-8850',
                'assetCode' => 'ASSET-PL-KAE-121',
                'assetName' => 'Sprężarka Śrubowa Kaeser SK 22 (Stacja Centralna B)',
                'location' => 'Linia B / Stacja Sprężarkowni Centralnej Bolechowo',
                'confidence' => 94,
                'anomalyTitle' => 'Wykryto anomalię FFT o prawdopodobieństwie 94% – Ryzyko awarii łożyska przed 18:00',
                'severity' => 'P1_CRITICAL',
                'modelUsed' => 'Ollama / Llama-3-AssetFix-8B-Q4',
            ],
            'fleetMtbfHours' => 840,
            'predictedAnomaliesCount' => 3,
            'activeSensorsCount' => 128,
            'aiAccuracyRate' => 97.2,
        ]);
    }
}
