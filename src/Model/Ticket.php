<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Ticket
{
    public function __construct(
        public int $id,
        public int $assetId,
        public string $assetName,
        public string $assetSerialNumber,
        public string $categoryName,
        public string $clientName,
        public string $clientCity,
        public int $reportedBy,
        public string $reporterName,
        public ?int $assignedTo,
        public string $technicianName,
        public string $title,
        public string $description,
        public TicketPriority $priority,
        public TicketStatus $status,
        public ?string $aiSuggestion,
        public ?string $scheduledFor,
        public string $createdAt,
        public string $updatedAt,
        public ?string $closedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            assetId: (int) $row['asset_id'],
            assetName: (string) $row['asset_name'],
            assetSerialNumber: (string) $row['asset_serial_number'],
            categoryName: (string) $row['category_name'],
            clientName: (string) $row['client_name'],
            clientCity: (string) $row['client_city'],
            reportedBy: (int) $row['reported_by'],
            reporterName: (string) $row['reporter_name'],
            assignedTo: isset($row['assigned_to']) ? (int) $row['assigned_to'] : null,
            technicianName: trim((string) ($row['technician_name'] ?? '')) ?: 'Nieprzypisane',
            title: (string) $row['title'],
            description: (string) $row['description'],
            priority: TicketPriority::from((string) $row['priority']),
            status: TicketStatus::from((string) $row['status']),
            aiSuggestion: isset($row['ai_suggestion']) ? (string) $row['ai_suggestion'] : null,
            scheduledFor: isset($row['scheduled_for']) ? (string) $row['scheduled_for'] : null,
            createdAt: (string) $row['created_at'],
            updatedAt: (string) $row['updated_at'],
            closedAt: isset($row['closed_at']) ? (string) $row['closed_at'] : null,
        );
    }
}
