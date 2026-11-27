<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database;
use App\Model\Ticket;
use PDO;

final class TicketRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * @return array<int, Ticket>
     */
    public function findAll(
        ?string $status = null,
        ?string $priority = null,
        ?string $search = null,
        ?string $filter = null,
    ): array {
        $sql = 'SELECT * FROM v_ticket_overview WHERE 1=1';
        $params = [];

        $allowedStatuses = ['OPEN', 'IN_PROGRESS', 'RESOLVED', 'CLOSED'];
        if ($status !== null && in_array($status, $allowedStatuses, true)) {
            $sql .= ' AND status = :status';
            $params['status'] = $status;
        }

        $allowedPriorities = ['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'];
        if ($priority !== null && in_array($priority, $allowedPriorities, true)) {
            $sql .= ' AND priority = :priority';
            $params['priority'] = $priority;
        }

        if ($filter === 'urgent') {
            $sql .= " AND priority IN ('HIGH', 'CRITICAL') AND status IN ('OPEN', 'IN_PROGRESS')";
        } elseif ($filter === 'today') {
            $sql .= " AND status IN ('OPEN', 'IN_PROGRESS') AND (scheduled_for::date <= CURRENT_DATE + INTERVAL '1 day' OR scheduled_for IS NULL)";
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= ' AND (title ILIKE :search OR asset_name ILIKE :search OR asset_serial_number ILIKE :search OR client_name ILIKE :search)';
            $params['search'] = '%' . trim($search) . '%';
        }

        $sql .= " ORDER BY CASE status WHEN 'OPEN' THEN 1 WHEN 'IN_PROGRESS' THEN 2 WHEN 'RESOLVED' THEN 3 ELSE 4 END, CASE priority WHEN 'CRITICAL' THEN 1 WHEN 'HIGH' THEN 2 WHEN 'MEDIUM' THEN 3 ELSE 4 END, created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return array_map(Ticket::fromRow(...), $stmt->fetchAll());
    }

    public function findById(int $id): ?Ticket
    {
        $stmt = $this->pdo->prepare('SELECT * FROM v_ticket_overview WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row === false ? null : Ticket::fromRow($row);
    }

    /**
     * @return array<int, Ticket>
     */
    public function findLatestActive(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM v_ticket_overview
             WHERE status IN ('OPEN', 'IN_PROGRESS')
             ORDER BY CASE priority WHEN 'CRITICAL' THEN 1 WHEN 'HIGH' THEN 2 WHEN 'MEDIUM' THEN 3 ELSE 4 END, created_at DESC
             LIMIT :limit"
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(Ticket::fromRow(...), $stmt->fetchAll());
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findHistoryByTicketId(int $ticketId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT th.id, th.old_status, th.new_status, th.note, th.created_at,
                    CONCAT(u.first_name, ' ', u.last_name) AS changed_by_name
             FROM ticket_history th
             LEFT JOIN users u ON u.id = th.changed_by
             WHERE th.ticket_id = :ticket_id
             ORDER BY th.created_at DESC"
        );
        $stmt->execute(['ticket_id' => $ticketId]);

        return $stmt->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findPhotosByTicketId(int $ticketId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT tp.id, tp.file_path, tp.original_name, tp.mime_type, tp.size_bytes, tp.created_at,
                    CONCAT(u.first_name, ' ', u.last_name) AS uploaded_by_name
             FROM ticket_photos tp
             LEFT JOIN users u ON u.id = tp.uploaded_by
             WHERE tp.ticket_id = :ticket_id
             ORDER BY tp.created_at DESC"
        );
        $stmt->execute(['ticket_id' => $ticketId]);

        return $stmt->fetchAll();
    }

    public function findLatestCriticalIncident(): ?Ticket
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM v_ticket_overview
             WHERE status IN ('OPEN', 'IN_PROGRESS')
             ORDER BY CASE priority WHEN 'CRITICAL' THEN 1 WHEN 'HIGH' THEN 2 WHEN 'MEDIUM' THEN 3 ELSE 4 END, created_at DESC
             LIMIT 1"
        );
        $row = $stmt->fetch();

        return $row === false ? null : Ticket::fromRow($row);
    }

    /**
     * @return array<int, Ticket>
     */
    public function findAiDiagnosed(int $limit = 8): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM v_ticket_overview
             WHERE ai_suggestion IS NOT NULL
             ORDER BY created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(Ticket::fromRow(...), $stmt->fetchAll());
    }

    /**
     * @return array<string, int>
     */
    public function getStats(): array
    {
        $stmt = $this->pdo->query(
            "SELECT
                COUNT(*)::int AS total,
                COUNT(*) FILTER (WHERE status = 'OPEN')::int AS open_count,
                COUNT(*) FILTER (WHERE status = 'IN_PROGRESS')::int AS in_progress_count,
                COUNT(*) FILTER (WHERE status = 'RESOLVED')::int AS resolved_count,
                COUNT(*) FILTER (WHERE status = 'CLOSED')::int AS closed_count,
                COUNT(*) FILTER (WHERE status IN ('OPEN', 'IN_PROGRESS'))::int AS active_count,
                COUNT(*) FILTER (WHERE priority IN ('CRITICAL', 'HIGH') AND status IN ('OPEN', 'IN_PROGRESS'))::int AS urgent_count,
                COUNT(*) FILTER (WHERE priority = 'CRITICAL' AND status IN ('OPEN', 'IN_PROGRESS'))::int AS critical_count
             FROM tickets"
        );

        /** @var array<string, int> $row */
        $row = $stmt->fetch() ?: [];

        return $row;
    }
}
