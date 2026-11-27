<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database;
use App\Model\User;
use PDO;

final class UserRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * @return array<int, User>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT
                u.id,
                u.email,
                u.first_name,
                u.last_name,
                u.employee_code,
                u.phone,
                u.base_location,
                u.is_active,
                u.created_at,
                r.name AS role_name,
                fn_open_tickets_for_technician(u.id) AS open_tickets_count,
                0 AS completed_tickets_count
             FROM users u
             JOIN roles r ON r.id = u.role_id
             ORDER BY r.name ASC, u.last_name ASC"
        );

        return array_map(User::fromRow(...), $stmt->fetchAll());
    }

    public function findDefaultTechnician(): ?User
    {
        $stmt = $this->pdo->query(
            "SELECT
                u.id,
                u.email,
                u.first_name,
                u.last_name,
                u.employee_code,
                u.phone,
                u.base_location,
                u.is_active,
                u.created_at,
                r.name AS role_name,
                fn_open_tickets_for_technician(u.id) AS open_tickets_count,
                (
                    SELECT COUNT(*)::int
                    FROM tickets t
                    WHERE t.assigned_to = u.id AND t.status IN ('RESOLVED', 'CLOSED')
                ) AS completed_tickets_count
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE r.name = 'TECHNICIAN' AND u.is_active = TRUE
             ORDER BY u.id ASC
             LIMIT 1"
        );
        $row = $stmt->fetch();

        return $row === false ? null : User::fromRow($row);
    }

    /**
     * @return array<string, int>
     */
    public function getStats(): array
    {
        $stmt = $this->pdo->query(
            "SELECT
                COUNT(*)::int AS total,
                COUNT(*) FILTER (WHERE r.name = 'TECHNICIAN' AND u.is_active = TRUE)::int AS active_technicians,
                COUNT(*) FILTER (WHERE r.name = 'ADMIN' AND u.is_active = TRUE)::int AS active_admins
             FROM users u
             JOIN roles r ON r.id = u.role_id"
        );

        /** @var array<string, int> $row */
        $row = $stmt->fetch() ?: [];

        return $row;
    }
}
