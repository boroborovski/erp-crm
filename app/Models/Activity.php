<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ActivityEvent;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Activity extends Model
{
    use HasUlids;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'team_id',
        'causer_id',
        'subject_type',
        'subject_id',
        'event',
        'description',
    ];

    /**
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'event' => ActivityEvent::class,
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
