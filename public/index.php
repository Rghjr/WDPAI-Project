<?php

declare(strict_types=1);

use App\Controller\AssetController;
use App\Controller\DefaultController;
use App\Controller\DiagnosticController;
use App\Controller\DispatchController;
use App\Controller\TicketController;
use App\Controller\UserController;
use App\Routing;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$routing = new Routing();

// Strona główna (Pulpit operacyjny)
$routing->get('/', DefaultController::class, 'index');

// Moduł Zgłoszeń i Awarie (TicketController)
$routing->get('/tickets', TicketController::class, 'index');
$routing->get('/tickets/add', TicketController::class, 'add');
$routing->get('/tickets/{id}', TicketController::class, 'show');

// Moduł EAM – Park Maszynowy i Paszport Techniczny (AssetController)
$routing->get('/assets', AssetController::class, 'index');
$routing->get('/assets/add', AssetController::class, 'add');
$routing->get('/assets/{id}', AssetController::class, 'show');

// Moduł Centrum Dyspozytorskiego, Mapy GIS i Harmonogramów UR (DispatchController)
$routing->get('/map', DispatchController::class, 'map');
$routing->get('/schedule', DispatchController::class, 'schedule');
$routing->get('/maintenance', DispatchController::class, 'schedule'); // Zintegrowane z harmonogramem dozoru UDT (bez powielania!)

// Moduł Predykcyjnej Analityki i Smart Diagnosis AI (DiagnosticController)
$routing->get('/diagnostics', DiagnosticController::class, 'index');

// Moduł Użytkowników, Kwalifikacji i Auth (UserController)
$routing->get('/admin/users', UserController::class, 'index');
$routing->get('/profile', UserController::class, 'profile');
$routing->get('/login', UserController::class, 'login');
$routing->post('/login', UserController::class, 'login');
$routing->get('/register', UserController::class, 'register');
$routing->post('/register', UserController::class, 'register');

$routeFound = $routing->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);

// Obsługa błędnych adresów (Odpowiedź 404)
if (!$routeFound) {
    http_response_code(404);
    (new DefaultController())->notFound();
}
