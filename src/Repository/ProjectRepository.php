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
}
