@php
    use App\Services\ReportRunner;

    $report = $getRecord();
    $runner = app(ReportRunner::class);

    $columns = $report->columns ?? [];
    $columnLabels = $report->entity->getAvailableColumns();

    $records = collect();
    $rows = collect();

    if (!empty($columns)) {
        $records = $runner->run($report);
        $rows = $runner->toRows($records, $columns);
    }
@endphp

<div>
    @if (empty($columns))
        <p class="text-sm text-gray-500 dark:text-gray-400 py-2">
            {{ __('reports.builder.no_columns_hint') }}
        </p>
    @elseif ($rows->isEmpty())
        <p class="text-sm text-gray-500 dark:text-gray-400 py-2">
            {{ __('reports.results.empty') }}
        </p>
    @else
        <p class="text-xs text-gray-400 dark:text-gray-500 mb-3">
            {{ __('reports.results.limit_note', ['count' => $rows->count()]) }}
        </p>

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        @foreach ($columns as $col)
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                {{ $columnLabels[$col] ?? $col }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($rows as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            @foreach ($columns as $col)
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    {{ $row[$col] ?? '' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
