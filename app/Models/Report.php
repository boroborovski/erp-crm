<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReportEntity;
use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $team_id
 * @property string $name
 * @property string|null $description
 * @property ReportEntity $entity
 * @property list<string> $columns
 * @property list<array<string, mixed>> $filters
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Report extends Model
{
    use HasTeam;
    use HasUlids;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'team_id',
        'name',
        'description',
        'entity',
        'columns',
        'filters',
    ];

    /**
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'entity' => ReportEntity::class,
            'columns' => 'array',
            'filters' => 'array',
        ];
    }
}
