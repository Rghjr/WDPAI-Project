<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProjectRepository;

final class ProjectController extends AppController
{
    public function __construct(
        private ProjectRepository $projectRepository,
    ) {
    }

    public function index(): void
    {
        $this->render('projects', [
            'pageTitle' => 'Projekty',
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    public function show(int $id): void
    {
        $project = $this->projectRepository->findById($id);

        if ($project === null) {
            http_response_code(404);
            $this->notFound();
            return;
        }

        $this->render('project', [
            'pageTitle' => 'Projekt: ' . $project->title,
            'project' => $project,
        ]);
    }
}
