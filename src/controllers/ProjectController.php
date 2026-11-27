<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Service\ProjectFormValidator;

final class ProjectController extends AppController
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private ProjectFormValidator $projectFormValidator,
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

    public function add(): void
    {
        $this->renderForm('Dodaj projekt', '/projects', [
            'title' => '',
            'description' => '',
            'status' => 'PLANNED',
        ]);
    }

    public function create(): void
    {
        $result = $this->projectFormValidator->validate($_POST);

        if ($result['errors'] !== []) {
            http_response_code(422);
            $this->renderForm('Dodaj projekt', '/projects', $result['data'], $result['errors']);
            return;
        }

        $id = $this->projectRepository->create(...$result['data']);
        $this->redirect('/projects/' . $id);
    }

    public function edit(int $id): void
    {
        $project = $this->projectRepository->findById($id);

        if ($project === null) {
            $this->renderNotFound();
            return;
        }

        $this->renderForm('Edytuj projekt', '/projects/' . $id, [
            'title' => $project->title,
            'description' => $project->description ?? '',
            'status' => $project->status,
        ], [], $id);
    }

    public function update(int $id): void
    {
        $result = $this->projectFormValidator->validate($_POST);

        if ($result['errors'] !== []) {
            http_response_code(422);
            $this->renderForm('Edytuj projekt', '/projects/' . $id, $result['data'], $result['errors'], $id);
            return;
        }

        if (!$this->projectRepository->update($id, ...$result['data'])) {
            $this->renderNotFound();
            return;
        }

        $this->redirect('/projects/' . $id);
    }

    public function delete(int $id): void
    {
        if (!$this->projectRepository->delete($id)) {
            $this->renderNotFound();
            return;
        }

        $this->redirect('/projects');
    }

    /**
     * @param array{title: string, description: ?string, status: string} $data
     * @param array<string, string> $errors
     */
    private function renderForm(string $pageTitle, string $formAction, array $data, array $errors = [], ?int $projectId = null): void
    {
        $this->render('project-form', [
            'pageTitle' => $pageTitle,
            'formAction' => $formAction,
            'project' => $data,
            'errors' => $errors,
            'projectId' => $projectId,
            'statuses' => $this->projectFormValidator->statuses(),
        ]);
    }

    private function renderNotFound(): void
    {
        http_response_code(404);
        $this->notFound();
    }

    private function redirect(string $path): never
    {
        header('Location: ' . $path, true, 303);
        exit;
    }
}
