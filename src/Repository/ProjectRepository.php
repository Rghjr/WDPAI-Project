<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Project;
use PDO;

final class ProjectRepository
{
    public function __construct(
        private PDO $pdo,
    ) {
    }

    /** @return array<int, Project> */
    public function findAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, title, description, status, created_at, updated_at
             FROM projects
             ORDER BY created_at DESC, id DESC'
        );

        return array_map(Project::fromRow(...), $statement->fetchAll());
    }

    public function findById(int $id): ?Project
    {
        $statement = $this->pdo->prepare(
            'SELECT id, title, description, status, created_at, updated_at
             FROM projects
             WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : Project::fromRow($row);
    }

    public function create(string $title, ?string $description, string $status): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO projects (title, description, status)
             VALUES (:title, :description, :status)
             RETURNING id'
        );
        $statement->execute([
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);

        return (int) $statement->fetchColumn();
    }

    public function update(int $id, string $title, ?string $description, string $status): bool
    {
        $statement = $this->pdo->prepare(
            'UPDATE projects
             SET title = :title, description = :description, status = :status, updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);

        return $statement->rowCount() === 1;
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare('DELETE FROM projects WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() === 1;
    }
}
