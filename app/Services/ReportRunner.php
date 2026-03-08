<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class ReportRunner
{
    private const int MAX_RESULTS = 500;

    /**
     * Run the report query and return the raw records.
     *
     * @return Collection<int, Model>
     */
    public function run(Report $report): Collection
    {
        $modelClass = $report->entity->getModelClass();
        $columns = $report->columns ?? [];
        $filters = $report->filters ?? [];

        /** @var Builder<Model> $query */
        $query = $modelClass::query()->where('team_id', $report->team_id);

        if (in_array('company_name', $columns, true)) {
            $query->with('company:id,name');
        }

        if (in_array('contact_name', $columns, true)) {
            $query->with('contact:id,name');
        }

        foreach ($filters as $filter) {
            $this->applyFilter($query, $filter);
        }

        return $query->limit(self::MAX_RESULTS)->get();
    }

    /**
     * Convert raw records to flat row arrays keyed by column.
     *
     * @param  Collection<int, Model>  $records
     * @param  list<string>  $columns
     * @return Collection<int, array<string, mixed>>
     */
    public function toRows(Collection $records, array $columns): Collection
    {
        return $records->map(function (Model $record) use ($columns): array {
            $row = [];

            foreach ($columns as $col) {
                $value = match ($col) {
                    'company_name' => $record->company?->name ?? '', // @phpstan-ignore-line
                    'contact_name' => $record->contact?->name ?? '', // @phpstan-ignore-line
                    default => $record->getAttribute($col),
                };

                if ($value instanceof \Illuminate\Support\Carbon) {
                    $value = $value->format('Y-m-d H:i');
                }

                $row[$col] = $value ?? '';
            }

            return $row;
        });
    }

    /**
     * @param  Builder<Model>  $query
     * @param  array<string, mixed>  $filter
     */
    private function applyFilter(Builder $query, array $filter): void
    {
        $field = (string) ($filter['field'] ?? '');
        $operator = (string) ($filter['operator'] ?? 'equals');
        $value = (string) ($filter['value'] ?? '');

        if ($field === '') {
            return;
        }

        match ($operator) {
            'equals' => $query->where($field, $value),
            'not_equals' => $query->where($field, '!=', $value),
            'contains' => $query->where($field, 'LIKE', "%{$value}%"),
            'starts_with' => $query->where($field, 'LIKE', "{$value}%"),
            'greater_than' => $query->where($field, '>', $value),
            'less_than' => $query->where($field, '<', $value),
            'is_empty' => $query->where(fn (Builder $q): Builder => $q->whereNull($field)->orWhere($field, '')),
            'is_not_empty' => $query->whereNotNull($field)->where($field, '!=', ''),
            default => null,
        };
    }
}
