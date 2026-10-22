<?php

declare(strict_types=1);

use App\Controller\AssetController;
use App\Controller\DefaultController;
use App\Controller\TicketController;
use App\Routing;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$routing = new Routing();

// Strona główna (DefaultController)
$routing->get('/', DefaultController::class, 'index');

// Trasy zwykłe
$routing->get('/tickets', TicketController::class, 'index');
$routing->get('/tickets/add', TicketController::class, 'add');
$routing->get('/assets', AssetController::class, 'index');
$routing->get('/login', AssetController::class, 'login');

// Trasa z parametrem
$routing->get('/tickets/{id}', TicketController::class, 'show');

$routeFound = $routing->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);

// Obsługa błędnych adresów (Odpowiedź 404)
if (!$routeFound) {
    http_response_code(404);
    (new DefaultController())->notFound();
}