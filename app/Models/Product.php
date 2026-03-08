<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductUnit;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;

/**
 * @property string $id
 * @property string $team_id
 * @property string|null $product_category_id
 * @property string $name
 * @property string|null $sku
 * @property string|null $description
 * @property string $unit_price
 * @property string $currency
 * @property ProductUnit $unit
 * @property bool $is_active
 * @property bool $track_stock
 * @property string $stock_quantity
 * @property string|null $low_stock_threshold
 * @property Carbon|null $deleted_at
 */
final class Product extends Model implements HasCustomFields
{
    use HasFactory;
    use HasTeam;
    use HasUlids;
    use SoftDeletes;
    use UsesCustomFields;

    /** @var list<string> */
    protected $fillable = [
        'team_id',
        'product_category_id',
        'name',
        'sku',
        'description',
        'unit_price',
        'currency',
        'unit',
        'is_active',
        'track_stock',
        'stock_quantity',
        'low_stock_threshold',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'unit'        => ProductUnit::class,
            'is_active'   => 'boolean',
            'track_stock' => 'boolean',
        ];
    }

    /** @return BelongsTo<ProductCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /** @return HasMany<StockMovement, $this> */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class)->latest();
    }

    public function isLowStock(): bool
    {
        if (! $this->track_stock || $this->low_stock_threshold === null) {
            return false;
        }

        return (float) $this->stock_quantity <= (float) $this->low_stock_threshold;
    }
}
