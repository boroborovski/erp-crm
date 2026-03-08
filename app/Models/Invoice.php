<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Enums\StockMovementType;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property string $id
 * @property string $team_id
 * @property string|null $quote_id
 * @property string|null $company_id
 * @property string|null $contact_id
 * @property string $invoice_number
 * @property InvoiceStatus $status
 * @property Carbon $issue_date
 * @property Carbon|null $due_date
 * @property string|null $notes
 * @property Carbon|null $deleted_at
 * @property-read float $subtotal
 * @property-read float $total_tax
 * @property-read float $grand_total
 * @property-read float $amount_paid
 * @property-read float $amount_outstanding
 */
final class Invoice extends Model
{
    use HasFactory;
    use HasTeam;
    use HasUlids;
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'team_id',
        'quote_id',
        'company_id',
        'contact_id',
        'invoice_number',
        'status',
        'issue_date',
        'due_date',
        'notes',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'status'     => InvoiceStatus::class,
            'issue_date' => 'date',
            'due_date'   => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $invoice): void {
            if (empty($invoice->invoice_number)) {
                $count = self::query()
                    ->where('team_id', $invoice->team_id)
                    ->withTrashed()
                    ->count() + 1;

                $invoice->invoice_number = 'INV-' . now()->format('Ym') . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }
        });

        static::updated(function (self $invoice): void {
            if ($invoice->wasChanged('status') && $invoice->status === InvoiceStatus::Void) {
                $invoice->reverseStockForLineItems();
            }
        });
    }

    public function reverseStockForLineItems(): void
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
                    'type'       => StockMovementType::Return,
                    'quantity'   => $qty,
                    'note'       => __('products.stock.auto_note_invoice_void', ['number' => $this->invoice_number]),
                    'created_by' => $userId,
                ]);

                $product->increment('stock_quantity', $qty);
            }
        });
    }

    /** @return BelongsTo<Quote, $this> */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
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

    /** @return HasMany<InvoiceLineItem, $this> */
    public function lineItems(): HasMany
    {
        return $this->hasMany(InvoiceLineItem::class)->orderBy('sort_order');
    }

    /** @return HasMany<Payment, $this> */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderBy('paid_at');
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->lineItems->sum(
            fn (InvoiceLineItem $item): float => round(
                (float) $item->quantity * (float) $item->unit_price * (1 - (float) $item->discount_pct / 100),
                4,
            )
        );
    }

    public function getTotalTaxAttribute(): float
    {
        return (float) $this->lineItems->sum(
            fn (InvoiceLineItem $item): float => round(
                (float) $item->quantity * (float) $item->unit_price * (1 - (float) $item->discount_pct / 100) * ((float) $item->tax_pct / 100),
                4,
            )
        );
    }

    public function getGrandTotalAttribute(): float
    {
        return round($this->subtotal + $this->total_tax, 4);
    }

    public function getAmountPaidAttribute(): float
    {
        return (float) $this->payments->sum(fn (Payment $p): float => (float) $p->amount);
    }

    public function getAmountOutstandingAttribute(): float
    {
        return round($this->grand_total - $this->amount_paid, 4);
    }

    public function recalculateStatus(): void
    {
        if ($this->status === InvoiceStatus::Void || $this->status === InvoiceStatus::Draft) {
            return;
        }

        $paid       = $this->amount_paid;
        $grandTotal = $this->grand_total;

        if ($grandTotal <= 0 || $paid >= $grandTotal) {
            $this->update(['status' => InvoiceStatus::Paid]);
        } elseif ($paid > 0) {
            $this->update(['status' => InvoiceStatus::Partial]);
        } elseif ($this->due_date !== null && $this->due_date->isPast()) {
            $this->update(['status' => InvoiceStatus::Overdue]);
        }
    }
}
