<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Bank  = 'bank';
    case Card  = 'card';
    case Cash  = 'cash';
    case Other = 'other';

    public function getLabel(): string
    {
        return __('invoices.payment_methods.' . $this->value);
    }
}
