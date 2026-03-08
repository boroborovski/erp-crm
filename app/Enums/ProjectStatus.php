<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasColor, HasLabel
{
    case Planning   = 'planning';
    case Active     = 'active';
    case OnHold     = 'on_hold';
    case Completed  = 'completed';
    case Cancelled  = 'cancelled';

    public function getLabel(): string
    {
        return __('projects.statuses.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Planning  => 'gray',
            self::Active    => 'info',
            self::OnHold    => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
