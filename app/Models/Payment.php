<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $invoice_id
 * @property string $amount
 * @property Carbon $paid_at
 * @property PaymentMethod $method
 * @property string|null $reference
 * @property string|null $notes
 */
final class Payment extends Model
{
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'invoice_id',
        'amount',
        'paid_at',
        'method',
        'reference',
        'notes',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'method'  => PaymentMethod::class,
            'paid_at' => 'datetime',
            'amount'  => 'decimal:4',
        ];
    }

    /** @return BelongsTo<Invoice, $this> */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
