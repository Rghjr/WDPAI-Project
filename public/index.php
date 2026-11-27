<?php

declare(strict_types=1);

use App\Controller\AssetController;
use App\Controller\DefaultController;
use App\Controller\DiagnosticController;
use App\Controller\DispatchController;
use App\Controller\ProjectController;
use App\Controller\TicketController;
use App\Controller\UserController;
use App\Database;
use App\Repository\AssetRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Routing;
use App\Service\ProjectFormValidator;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$database = Database::getConnection();
$ticketRepository = new TicketRepository($database);
$assetRepository = new AssetRepository($database);
$userRepository = new UserRepository($database);
$projectRepository = new ProjectRepository($database);
$projectFormValidator = new ProjectFormValidator();

$routing = new Routing();

$routing->register(
    DefaultController::class,
    static fn (): DefaultController => new DefaultController($ticketRepository, $assetRepository, $userRepository),
);
$routing->register(
    TicketController::class,
    static fn (): TicketController => new TicketController($ticketRepository, $assetRepository),
);
$routing->register(
    AssetController::class,
    static fn (): AssetController => new AssetController($assetRepository),
);
$routing->register(
    UserController::class,
    static fn (): UserController => new UserController($userRepository),
);
$routing->register(
    DispatchController::class,
    static fn (): DispatchController => new DispatchController($assetRepository, $userRepository, $ticketRepository),
);
$routing->register(
    DiagnosticController::class,
    static fn (): DiagnosticController => new DiagnosticController($ticketRepository, $assetRepository),
);
$routing->register(
    ProjectController::class,
    static fn (): ProjectController => new ProjectController($projectRepository, $projectFormValidator),
);

// Strona główna (Pulpit operacyjny)
$routing->get('/', DefaultController::class, 'index');

// Moduł Zgłoszeń i Awarie (TicketController)
$routing->get('/tickets', TicketController::class, 'index');
$routing->get('/tickets/add', TicketController::class, 'add');
$routing->get('/tickets/{id}', TicketController::class, 'show');
$routing->post('/tickets/{id}', TicketController::class, 'updateStatus');

// Moduł EAM – Park Maszynowy i Paszport Techniczny (AssetController)
$routing->get('/assets', AssetController::class, 'index');
$routing->get('/assets/add', AssetController::class, 'add');
$routing->get('/assets/{id}', AssetController::class, 'show');

// Moduł Centrum Dyspozytorskiego, Mapy GIS i Harmonogramów UR (DispatchController)
$routing->get('/map', DispatchController::class, 'map');
$routing->get('/schedule', DispatchController::class, 'schedule');
$routing->get('/maintenance', DispatchController::class, 'schedule');

// Moduł Predykcyjnej Analityki i Smart Diagnosis AI (DiagnosticController)
$routing->get('/diagnostics', DiagnosticController::class, 'index');

// Moduł Użytkowników, Kwalifikacji i Auth (UserController)
$routing->get('/admin/users', UserController::class, 'index');
$routing->get('/profile', UserController::class, 'profile');
$routing->get('/login', UserController::class, 'login');

$routing->get('/projects', ProjectController::class, 'index');
$routing->get('/projects/add', ProjectController::class, 'add');
$routing->get('/projects/{id}', ProjectController::class, 'show');
$routing->get('/projects/{id}/edit', ProjectController::class, 'edit');
$routing->post('/projects', ProjectController::class, 'create');
$routing->post('/projects/{id}', ProjectController::class, 'update');
$routing->post('/projects/{id}/delete', ProjectController::class, 'delete');

$routeFound = $routing->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);

// Obsługa błędnych adresów (Odpowiedź 404)
if (!$routeFound) {
    http_response_code(404);
    (new DefaultController($ticketRepository, $assetRepository, $userRepository))->notFound();
}
