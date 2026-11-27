<?php

declare(strict_types=1);

namespace App\Model;

enum TicketStatus: string
{
    case OPEN = 'OPEN';
    case IN_PROGRESS = 'IN_PROGRESS';
    case RESOLVED = 'RESOLVED';
    case CLOSED = 'CLOSED';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Otwarte',
            self::IN_PROGRESS => 'W trakcie',
            self::RESOLVED => 'Rozwiązane',
            self::CLOSED => 'Zamknięte',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::OPEN => 'badge-blue',
            self::IN_PROGRESS => 'badge-amber',
            self::RESOLVED, self::CLOSED => 'badge-green',
        };
    }

    public function iconClass(): string
    {
        return match ($this) {
            self::OPEN => 'fa-envelope-open',
            self::IN_PROGRESS => 'fa-clock',
            self::RESOLVED => 'fa-check',
            self::CLOSED => 'fa-lock',
        };
    }
}
