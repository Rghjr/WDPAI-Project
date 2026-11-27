<?php

declare(strict_types=1);

namespace App\Model;

final readonly class User
{
    public function __construct(
        public int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $roleName,
        public ?string $employeeCode,
        public ?string $phone,
        public ?string $baseLocation,
        public bool $isActive,
        public string $createdAt,
        public int $openTicketsCount,
        public int $completedTicketsCount,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            email: (string) $row['email'],
            firstName: (string) $row['first_name'],
            lastName: (string) $row['last_name'],
            roleName: (string) $row['role_name'],
            employeeCode: isset($row['employee_code']) ? (string) $row['employee_code'] : null,
            phone: isset($row['phone']) ? (string) $row['phone'] : null,
            baseLocation: isset($row['base_location']) ? (string) $row['base_location'] : null,
            isActive: (bool) $row['is_active'],
            createdAt: (string) $row['created_at'],
            openTicketsCount: (int) ($row['open_tickets_count'] ?? 0),
            completedTicketsCount: (int) ($row['completed_tickets_count'] ?? 0),
        );
    }

    public function fullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function isAdmin(): bool
    {
        return $this->roleName === 'ADMIN';
    }
}
