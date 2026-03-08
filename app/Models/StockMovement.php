<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StockMovementType;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $team_id
 * @property string $product_id
 * @property StockMovementType $type
 * @property string $quantity
 * @property string|null $note
 * @property int $created_by
 * @property Carbon|null $deleted_at
 */
final class StockMovement extends Model
{
    use HasFactory;
    use HasTeam;
    use HasUlids;
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'team_id',
        'product_id',
        'type',
        'quantity',
        'note',
        'created_by',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'type' => StockMovementType::class,
        ];
    }

    /** @return BelongsTo<Product, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** @return BelongsTo<Team, $this> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /** @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
