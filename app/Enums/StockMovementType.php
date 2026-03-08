<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StockMovementType: string implements HasColor, HasLabel
{
    case Restock    = 'restock';
    case Adjustment = 'adjustment';
    case Sale       = 'sale';
    case Return     = 'return';

    public function getLabel(): string
    {
        return __('products.stock.movement_types.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Restock    => 'success',
            self::Adjustment => 'warning',
            self::Sale       => 'danger',
            self::Return     => 'info',
        };
    }

    /** Returns the signed quantity delta for this movement type given a positive quantity value. */
    public function quantityDelta(float $quantity): float
    {
        return match ($this) {
            self::Restock    => $quantity,
            self::Adjustment => $quantity,
            self::Sale       => -$quantity,
            self::Return     => $quantity,
        };
    }
}
