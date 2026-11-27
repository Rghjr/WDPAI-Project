<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Asset
{
    public function __construct(
        public int $id,
        public int $clientId,
        public string $clientName,
        public string $clientCity,
        public string $clientAddress,
        public int $categoryId,
        public string $categoryName,
        public string $name,
        public string $serialNumber,
        public AssetStatus $status,
        public ?string $manufacturer,
        public ?string $model,
        public ?int $productionYear,
        public ?string $udtNumber,
        public ?string $locationDetails,
        public ?string $lastInspectionAt,
        public ?string $nextInspectionAt,
        public ?string $udtValidUntil,
        public int $operatingHours,
        public string $technicianName,
        public ?string $technicianCode,
        public ?int $activeTicketId,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            clientId: (int) $row['client_id'],
            clientName: (string) $row['client_name'],
            clientCity: (string) $row['client_city'],
            clientAddress: (string) $row['client_address'],
            categoryId: (int) $row['category_id'],
            categoryName: (string) $row['category_name'],
            name: (string) $row['name'],
            serialNumber: (string) $row['serial_number'],
            status: AssetStatus::from((string) $row['status']),
            manufacturer: isset($row['manufacturer']) ? (string) $row['manufacturer'] : null,
            model: isset($row['model']) ? (string) $row['model'] : null,
            productionYear: isset($row['production_year']) ? (int) $row['production_year'] : null,
            udtNumber: isset($row['udt_number']) ? (string) $row['udt_number'] : null,
            locationDetails: isset($row['location_details']) ? (string) $row['location_details'] : null,
            lastInspectionAt: isset($row['last_inspection_at']) ? (string) $row['last_inspection_at'] : null,
            nextInspectionAt: isset($row['next_inspection_at']) ? (string) $row['next_inspection_at'] : null,
            udtValidUntil: isset($row['udt_valid_until']) ? (string) $row['udt_valid_until'] : null,
            operatingHours: (int) ($row['operating_hours'] ?? 0),
            technicianName: trim((string) ($row['technician_name'] ?? '')) ?: 'Nieprzypisany',
            technicianCode: isset($row['technician_code']) ? (string) $row['technician_code'] : null,
            activeTicketId: isset($row['active_ticket_id']) ? (int) $row['active_ticket_id'] : null,
        );
    }

    public function isInspectionSoon(): bool
    {
        return $this->nextInspectionAt !== null && strtotime($this->nextInspectionAt) < strtotime('+14 days');
    }
}
