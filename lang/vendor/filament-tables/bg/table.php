<?php

declare(strict_types=1);

return [
    'column_manager' => [
        'heading' => 'Колони',
        'actions' => [
            'apply' => ['label' => 'Приложи колони'],
            'reset' => ['label' => 'Нулирай'],
        ],
    ],

    'columns' => [
        'actions' => ['label' => 'Действие|Действия'],
        'select' => [
            'loading_message' => 'Зареждане...',
            'no_options_message' => 'Няма налични опции.',
            'no_search_results_message' => 'Няма съответстващи опции.',
            'placeholder' => 'Изберете опция',
            'searching_message' => 'Търсене...',
            'search_prompt' => 'Започнете да пишете за търсене...',
        ],
        'text' => [
            'actions' => [
                'collapse_list' => 'Покажи :count по-малко',
                'expand_list' => 'Покажи :count повече',
            ],
            'more_list_items' => 'и :count повече',
        ],
    ],

    'fields' => [
        'bulk_select_page' => ['label' => 'Избери/отмени всички елементи за групови действия.'],
        'bulk_select_record' => ['label' => 'Избери/отмени елемент :key за групови действия.'],
        'bulk_select_group' => ['label' => 'Избери/отмени група :title за групови действия.'],
        'search' => [
            'label' => 'Търсене',
            'placeholder' => 'Търсене',
            'indicator' => 'Търсене',
        ],
    ],

    'summary' => [
        'heading' => 'Обобщение',
        'subheadings' => [
            'all' => 'Всички :label',
            'group' => 'Обобщение на :group',
            'page' => 'Тази страница',
        ],
        'summarizers' => [
            'average' => ['label' => 'Средно'],
            'count' => ['label' => 'Брой'],
            'sum' => ['label' => 'Сума'],
        ],
    ],

    'actions' => [
        'disable_reordering' => ['label' => 'Приключи пренареждането'],
        'enable_reordering' => ['label' => 'Пренареди записите'],
        'filter' => ['label' => 'Филтър'],
        'group' => ['label' => 'Групирай'],
        'open_bulk_actions' => ['label' => 'Групови действия'],
        'column_manager' => ['label' => 'Управление на колони'],
    ],

    'empty' => [
        'heading' => 'Няма :model',
        'description' => 'Създайте :model, за да започнете.',
    ],

    'filters' => [
        'actions' => [
            'apply' => ['label' => 'Приложи филтри'],
            'remove' => ['label' => 'Премахни филтър'],
            'remove_all' => ['label' => 'Премахни всички филтри', 'tooltip' => 'Премахни всички филтри'],
            'reset' => ['label' => 'Нулирай'],
        ],
        'heading' => 'Филтри',
        'indicator' => 'Активни филтри',
        'multi_select' => ['placeholder' => 'Всички'],
        'select' => [
            'placeholder' => 'Всички',
            'relationship' => ['empty_option_label' => 'Няма'],
        ],
        'trashed' => [
            'label' => 'Изтрити записи',
            'only_trashed' => 'Само изтрити записи',
            'with_trashed' => 'С изтрити записи',
            'without_trashed' => 'Без изтрити записи',
        ],
    ],

    'grouping' => [
        'fields' => [
            'group' => ['label' => 'Групирай по'],
            'direction' => [
                'label' => 'Посока на групиране',
                'options' => ['asc' => 'Възходящо', 'desc' => 'Низходящо'],
            ],
        ],
    ],

    'reorder_indicator' => 'Плъзнете и пуснете записите в желания ред.',

    'selection_indicator' => [
        'selected_count' => '1 запис избран|:count записа избрани',
        'actions' => [
            'select_all' => ['label' => 'Избери всички :count'],
            'deselect_all' => ['label' => 'Отмени избора'],
        ],
    ],

    'sorting' => [
        'fields' => [
            'column' => ['label' => 'Сортирай по'],
            'direction' => [
                'label' => 'Посока на сортиране',
                'options' => ['asc' => 'Възходящо', 'desc' => 'Низходящо'],
            ],
        ],
    ],

    'default_model_label' => 'запис',
];
