<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\StockMovementType;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property string $id
 * @property string $team_id
 * @property string|null $opportunity_id
 * @property string|null $company_id
 * @property string|null $contact_id
 * @property string $quote_number
 * @property QuoteStatus $status
 * @property Carbon|null $valid_until
 * @property string|null $notes
 * @property Carbon|null $deleted_at
 * @property-read float $subtotal
 * @property-read float $total_tax
 * @property-read float $grand_total
 */
final class Quote extends Model
{
    use HasFactory;
    use HasTeam;
    use HasUlids;
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'team_id',
        'opportunity_id',
        'company_id',
        'contact_id',
        'quote_number',
        'status',
        'valid_until',
        'notes',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'status'      => QuoteStatus::class,
            'valid_until' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $quote): void {
            if (empty($quote->quote_number)) {
                $count = self::query()
                    ->where('team_id', $quote->team_id)
                    ->withTrashed()
                    ->count() + 1;

                $quote->quote_number = 'Q-' . now()->format('Ym') . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }
        });

        static::updated(function (self $quote): void {
            if ($quote->wasChanged('status') && $quote->status === QuoteStatus::Accepted) {
                $quote->reduceStockForLineItems();
            }
        });
    }

    public function reduceStockForLineItems(): void
    {
        $userId = Auth::id();

        if ($userId === null) {
            return;
        }

        $this->load('lineItems.product');

        DB::transaction(function () use ($userId): void {
            foreach ($this->lineItems as $item) {
                $product = $item->product;

                if ($product === null || ! $product->track_stock) {
                    continue;
                }

                $qty = (float) $item->quantity;

                StockMovement::query()->create([
                    'team_id'    => $this->team_id,
                    'product_id' => $product->getKey(),
                    'type'       => StockMovementType::Sale,
                    'quantity'   => $qty,
                    'note'       => __('products.stock.auto_note_quote', ['number' => $this->quote_number]),
                    'created_by' => $userId,
                ]);

                $product->decrement('stock_quantity', $qty);
            }
        });
    }

    /** @return BelongsTo<Opportunity, $this> */
    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }

    /** @return BelongsTo<Company, $this> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** @return BelongsTo<People, $this> */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(People::class, 'contact_id');
    }

    /** @return HasMany<QuoteLineItem, $this> */
    public function lineItems(): HasMany
    {
        return $this->hasMany(QuoteLineItem::class)->orderBy('sort_order');
    }

    /** @return HasOne<Invoice, $this> */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->lineItems->sum(
            fn (QuoteLineItem $item): float => round(
                (float) $item->quantity * (float) $item->unit_price * (1 - (float) $item->discount_pct / 100),
                4,
            )
        );
    }

    public function getTotalTaxAttribute(): float
    {
        return (float) $this->lineItems->sum(
            fn (QuoteLineItem $item): float => round(
                (float) $item->quantity * (float) $item->unit_price * (1 - (float) $item->discount_pct / 100) * ((float) $item->tax_pct / 100),
                4,
            )
        );
    }

    public function getGrandTotalAttribute(): float
    {
        return round($this->subtotal + $this->total_tax, 4);
    }
}
