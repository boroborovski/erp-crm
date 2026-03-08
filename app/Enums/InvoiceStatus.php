<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InvoiceStatus: string implements HasColor, HasLabel
{
    case Draft   = 'draft';
    case Issued  = 'issued';
    case Partial = 'partial';
    case Paid    = 'paid';
    case Overdue = 'overdue';
    case Void    = 'void';

    public function getLabel(): string
    {
        return __('invoices.statuses.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft   => 'gray',
            self::Issued  => 'info',
            self::Partial => 'warning',
            self::Paid    => 'success',
            self::Overdue => 'danger',
            self::Void    => 'gray',
        };
    }
}
