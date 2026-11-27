<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database;
use App\Model\Asset;
use App\Model\AssetStatus;
use PDO;

final class AssetRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * @return array<int, Asset>
     */
    public function findAll(?string $category = null, ?string $status = null, ?string $search = null): array
    {
        $sql = "SELECT
                    a.*,
                    ac.name AS category_name,
                    c.name AS client_name,
                    c.city AS client_city,
                    c.address AS client_address,
                    CONCAT(u.first_name, ' ', u.last_name) AS technician_name,
                    u.employee_code AS technician_code,
                    (
                        SELECT t.id
                        FROM tickets t
                        WHERE t.asset_id = a.id AND t.status IN ('OPEN', 'IN_PROGRESS')
                        ORDER BY t.created_at DESC
                        LIMIT 1
                    ) AS active_ticket_id
                FROM assets a
                JOIN asset_categories ac ON ac.id = a.category_id
                JOIN clients c ON c.id = a.client_id
                LEFT JOIN users u ON u.id = a.assigned_technician_id
                WHERE 1=1";
        $params = [];

        if ($category !== null && trim($category) !== '') {
            $sql .= ' AND ac.name = :category';
            $params['category'] = trim($category);
        }

        $allowedStatuses = ['OPERATIONAL', 'IN_REPAIR', 'OUT_OF_SERVICE'];
        if ($status !== null && in_array($status, $allowedStatuses, true)) {
            $sql .= ' AND a.status = :status';
            $params['status'] = $status;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= ' AND (a.name ILIKE :search OR a.serial_number ILIKE :search OR ac.name ILIKE :search OR c.name ILIKE :search OR c.city ILIKE :search)';
            $params['search'] = '%' . trim($search) . '%';
        }

        $sql .= ' ORDER BY a.id ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return array_map(Asset::fromRow(...), $stmt->fetchAll());
    }

    public function findById(int $id): ?Asset
    {
        $stmt = $this->pdo->prepare(
            "SELECT
                a.*,
                ac.name AS category_name,
                c.name AS client_name,
                c.city AS client_city,
                c.address AS client_address,
                c.latitude AS client_latitude,
                c.longitude AS client_longitude,
                CONCAT(u.first_name, ' ', u.last_name) AS technician_name,
                u.employee_code AS technician_code,
                (
                    SELECT t.id
                    FROM tickets t
                    WHERE t.asset_id = a.id AND t.status IN ('OPEN', 'IN_PROGRESS')
                    ORDER BY t.created_at DESC
                    LIMIT 1
                ) AS active_ticket_id
            FROM assets a
            JOIN asset_categories ac ON ac.id = a.category_id
            JOIN clients c ON c.id = a.client_id
            LEFT JOIN users u ON u.id = a.assigned_technician_id
            WHERE a.id = :id
            LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row === false ? null : Asset::fromRow($row);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findCategories(): array
    {
        $stmt = $this->pdo->query('SELECT id, name FROM asset_categories ORDER BY name ASC');

        return $stmt->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findUpcomingInspections(int $days = 60): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM v_upcoming_inspections
             WHERE days_until_inspection <= :days
             ORDER BY next_inspection_at ASC'
        );
        $stmt->bindValue('days', $days, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findClientLocations(): array
    {
        $stmt = $this->pdo->query(
            "SELECT
                c.id,
                c.name,
                c.address,
                c.city,
                c.latitude,
                c.longitude,
                COUNT(DISTINCT a.id)::int AS asset_count,
                COUNT(DISTINCT t.id) FILTER (WHERE t.status IN ('OPEN', 'IN_PROGRESS'))::int AS active_tickets_count
             FROM clients c
             LEFT JOIN assets a ON a.client_id = c.id
             LEFT JOIN tickets t ON t.asset_id = a.id
             GROUP BY c.id
             ORDER BY active_tickets_count DESC, c.name ASC"
        );

        return $stmt->fetchAll();
    }

    /**
     * @return array<string, int>
     */
    public function getStats(): array
    {
        $stmt = $this->pdo->query(
            "SELECT
                COUNT(*)::int AS total,
                COUNT(*) FILTER (WHERE status = 'OPERATIONAL')::int AS operational_count,
                COUNT(*) FILTER (WHERE status = 'IN_REPAIR')::int AS in_repair_count,
                COUNT(*) FILTER (WHERE status = 'OUT_OF_SERVICE')::int AS out_of_service_count,
                COUNT(*) FILTER (WHERE next_inspection_at IS NOT NULL AND next_inspection_at <= CURRENT_DATE + INTERVAL '30 days')::int AS due_30_days,
                COUNT(*) FILTER (WHERE next_inspection_at IS NOT NULL AND next_inspection_at <= CURRENT_DATE + INTERVAL '7 days')::int AS due_7_days
             FROM assets"
        );

        /** @var array<string, int> $row */
        $row = $stmt->fetch() ?: [];

        return $row;
    }

    public function create(
        int $clientId,
        int $categoryId,
        string $name,
        string $serialNumber,
        AssetStatus $status = AssetStatus::OPERATIONAL,
        ?string $manufacturer = null,
        ?string $model = null,
        ?int $productionYear = null,
        ?string $udtNumber = null,
        ?string $locationDetails = null,
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO assets (
                client_id, category_id, name, serial_number, status,
                manufacturer, model, production_year, udt_number, location_details
            ) VALUES (
                :client_id, :category_id, :name, :serial_number, :status::asset_status,
                :manufacturer, :model, :production_year, :udt_number, :location_details
            )
            RETURNING id'
        );
        $stmt->execute([
            'client_id' => $clientId,
            'category_id' => $categoryId,
            'name' => $name,
            'serial_number' => $serialNumber,
            'status' => $status->value,
            'manufacturer' => $manufacturer,
            'model' => $model,
            'production_year' => $productionYear,
            'udt_number' => $udtNumber,
            'location_details' => $locationDetails,
        ]);

        return (int) $stmt->fetchColumn();
    }
}
