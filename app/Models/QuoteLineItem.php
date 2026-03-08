<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $quote_id
 * @property string|null $product_id
 * @property string $description
 * @property string $quantity
 * @property string $unit_price
 * @property string $discount_pct
 * @property string $tax_pct
 * @property int $sort_order
 * @property-read float $line_subtotal
 * @property-read float $total
 */
final class QuoteLineItem extends Model
{
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'quote_id',
        'product_id',
        'description',
        'quantity',
        'unit_price',
        'discount_pct',
        'tax_pct',
        'sort_order',
    ];

    /** @return BelongsTo<Quote, $this> */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    /** @return BelongsTo<Product, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getLineSubtotalAttribute(): float
    {
        return round(
            (float) $this->quantity * (float) $this->unit_price * (1 - (float) $this->discount_pct / 100),
            4,
        );
    }

    public function getTotalAttribute(): float
    {
        return round($this->line_subtotal * (1 + (float) $this->tax_pct / 100), 4);
    }
}
