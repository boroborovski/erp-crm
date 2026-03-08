<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property string $id
 * @property string $team_id
 * @property string|null $company_id
 * @property string|null $opportunity_id
 * @property string $name
 * @property string|null $description
 * @property ProjectStatus $status
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property float|null $order_column
 * @property Carbon|null $deleted_at
 */
final class Project extends Model
{
    use HasFactory;
    use HasTeam;
    use HasUlids;
    use SoftDeletes;
    use SortableTrait;

    /** @var list<string> */
    protected $fillable = [
        'team_id',
        'company_id',
        'opportunity_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'order_column',
    ];

    /** @var array{order_column_name: string, sort_when_creating: bool} */
    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    /** @return array<string, string|class-string> */
    protected function casts(): array
    {
        return [
            'status'     => ProjectStatus::class,
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    /** @return BelongsTo<Company, $this> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** @return BelongsTo<Opportunity, $this> */
    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }

    /** @return HasMany<Milestone, $this> */
    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class)->orderBy('due_date');
    }

    /** @return HasMany<Task, $this> */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('order_column');
    }
}
