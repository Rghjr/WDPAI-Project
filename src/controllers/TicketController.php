<?php

declare(strict_types=1);

namespace App\Controller;

final class TicketController extends AppController
{
    // Trasa zwykła: /tickets
    public function index(): void
    {
        $this->render('tickets', [
            'pageTitle' => 'AssetFix AI – Lista Zgłoszeń Awarii',
            'openTicketsCount' => 3,
        ]);
    }

    // Trasa z parametrem: /tickets/{id}
    public function show(int $id): void
    {
        // Przekazanie więcej niż 2 wartości z kontrolera do widoku
        $this->render('ticket', [
            'pageTitle' => 'Szczegóły Awarii #' . $id,
            'ticketId' => $id,
            'assetName' => 'Turbina Wiatrowa V90 #04',
            'serialNumber' => 'TURB-2024-9004',
            'status' => 'w_trakcie',
            'description' => 'Niski poziom oleju w przekładni głównej, gwałtowny wzrost temperatury.',
            'aiSuggestion' => 'Ollama (Smart Diagnosis): Wykryto ryzyko przegrzania łożyska. Zalecana wymiana filtra oraz dolewka oleju SynthGear 320.',
            'createdAt' => '2026-10-22 14:10',
        ]);
    }

    // Trasa zwykła: /tickets/add
    public function add(): void
    {
        $this->render('add-ticket', [
            'pageTitle' => 'Zgłoś Nową Awarię',
        ]);
    }
}