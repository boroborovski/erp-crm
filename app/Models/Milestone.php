<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $project_id
 * @property string $name
 * @property Carbon|null $due_date
 * @property bool $is_completed
 */
final class Milestone extends Model
{
    use HasFactory;
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'project_id',
        'name',
        'due_date',
        'is_completed',
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'due_date'     => 'date',
            'is_completed' => 'boolean',
        ];
    }

    /** @return BelongsTo<Project, $this> */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
