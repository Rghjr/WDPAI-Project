<?php

declare(strict_types=1);

namespace App\Model;

enum TicketPriority: string
{
    case LOW = 'LOW';
    case MEDIUM = 'MEDIUM';
    case HIGH = 'HIGH';
    case CRITICAL = 'CRITICAL';

    public function label(): string
    {
        return match ($this) {
            self::CRITICAL => 'KRYTYCZNY',
            self::HIGH => 'WYSOKI',
            self::MEDIUM => 'ŚREDNI',
            self::LOW => 'NISKI',
        };
    }

    public function slaLabel(): string
    {
        return match ($this) {
            self::CRITICAL => 'KRYTYCZNY (SLA 2H)',
            self::HIGH => 'WYSOKI (SLA 4H)',
            self::MEDIUM => 'ŚREDNI (SLA 24H)',
            self::LOW => 'NISKI (SLA 72H)',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::CRITICAL => 'badge-red',
            self::HIGH => 'badge-amber',
            self::MEDIUM => 'badge-blue',
            self::LOW => 'badge-green',
        };
    }

    public function borderClass(): string
    {
        return match ($this) {
            self::CRITICAL => 'border-red',
            self::HIGH => 'border-amber',
            default => 'border-green',
        };
    }

    public function iconClass(): string
    {
        return match ($this) {
            self::CRITICAL => 'fa-fire',
            self::HIGH => 'fa-triangle-exclamation',
            self::MEDIUM => 'fa-circle-info',
            self::LOW => 'fa-circle-check',
        };
    }
}
