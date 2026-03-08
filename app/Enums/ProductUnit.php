<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductUnit: string
{
    case Each = 'ea';
    case Hour = 'hr';
    case Day = 'day';

    public function getLabel(): string
    {
        return match ($this) {
            self::Each => __('products.units.ea'),
            self::Hour => __('products.units.hr'),
            self::Day  => __('products.units.day'),
        };
    }

    /** @return array<string, string> */
    public static function selectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $unit): array => [$unit->value => $unit->getLabel()])
            ->all();
    }
}
