<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum QuoteStatus: string implements HasColor, HasLabel
{
    case Draft    = 'draft';
    case Sent     = 'sent';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired  = 'expired';

    public function getLabel(): string
    {
        return __('quotes.statuses.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft    => 'gray',
            self::Sent     => 'info',
            self::Accepted => 'success',
            self::Rejected => 'danger',
            self::Expired  => 'warning',
        };
    }
}
