<?php

declare(strict_types=1);

namespace App\Model;

enum AssetStatus: string
{
    case OPERATIONAL = 'OPERATIONAL';
    case IN_REPAIR = 'IN_REPAIR';
    case OUT_OF_SERVICE = 'OUT_OF_SERVICE';

    public function label(): string
    {
        return match ($this) {
            self::OPERATIONAL => 'SPRAWNA',
            self::IN_REPAIR => 'W NAPRAWIE',
            self::OUT_OF_SERVICE => 'AWARIA',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::OPERATIONAL => 'badge-green',
            self::IN_REPAIR => 'badge-amber',
            self::OUT_OF_SERVICE => 'badge-red',
        };
    }

    public function iconClass(): string
    {
        return match ($this) {
            self::OPERATIONAL => 'fa-check',
            self::IN_REPAIR => 'fa-clock',
            self::OUT_OF_SERVICE => 'fa-triangle-exclamation',
        };
    }
}
