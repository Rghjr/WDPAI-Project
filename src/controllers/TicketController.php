<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\TicketRepository;

final class TicketController extends AppController
{
    // Trasa zwykła: /tickets
    public function index(): void
    {
        $ticketRepo = new TicketRepository();

        $status = isset($_GET['status']) && is_string($_GET['status']) ? strtoupper($_GET['status']) : null;
        $priority = isset($_GET['priority']) && is_string($_GET['priority']) ? strtoupper($_GET['priority']) : null;
        $filter = isset($_GET['filter']) && is_string($_GET['filter']) ? strtolower($_GET['filter']) : null;
        $search = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : null;

        $this->render('tickets', [
            'pageTitle' => 'AssetFix AI – Lista Zgłoszeń Awarii',
            'tickets' => $ticketRepo->findAll($status, $priority, $search, $filter),
            'stats' => $ticketRepo->getStats(),
            'activeStatus' => $status,
            'activeFilter' => $filter,
            'searchQuery' => $search ?? '',
        ]);
    }

    // Trasa z parametrem: /tickets/{id}
    public function show(int $id): void
    {
        if ($id <= 0) {
            http_response_code(400);
            $this->render('not-found', ['pageTitle' => 'Nieprawidłowe ID zgłoszenia']);
            return;
        }

        $ticketRepo = new TicketRepository();
        $ticket = $ticketRepo->findById($id);

        if ($ticket === null) {
            http_response_code(404);
            $this->render('not-found', ['pageTitle' => 'Nie znaleziono zgłoszenia']);
            return;
        }

        $this->render('ticket', [
            'pageTitle' => 'Szczegóły Awarii #' . $id,
            'ticket' => $ticket,
            'history' => $ticketRepo->findHistoryByTicketId($id),
            'photos' => $ticketRepo->findPhotosByTicketId($id),
        ]);
    }

    // Trasa zwykła: /tickets/add
    public function add(): void
    {
        $assetRepo = new AssetRepository();

        $this->render('add-ticket', [
            'pageTitle' => 'Zgłoś Nową Awarię',
            'assets' => $assetRepo->findAll(),
        ]);
    }
}
