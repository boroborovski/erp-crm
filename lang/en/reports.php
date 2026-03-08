<?php

declare(strict_types=1);

return [
    'builder' => [
        'heading' => 'Report Builder',
        'fields' => [
            'name' => 'Report Name',
            'description' => 'Description',
            'entity' => 'Data Source',
            'columns' => 'Columns to Display',
            'filters' => 'Filter Conditions',
            'filter_field' => 'Field',
            'filter_operator' => 'Condition',
            'filter_value' => 'Value',
        ],
        'add_filter' => 'Add filter',
        'no_columns_hint' => 'Select a data source first.',
    ],

    'columns' => [
        'name' => 'Name',
        'phone' => 'Phone',
        'address' => 'Address',
        'country' => 'Country',
        'company' => 'Company',
        'contact' => 'Contact',
        'created_at' => 'Created At',
    ],

    'operators' => [
        'equals' => 'equals',
        'not_equals' => 'not equals',
        'contains' => 'contains',
        'starts_with' => 'starts with',
        'greater_than' => 'greater than',
        'less_than' => 'less than',
        'is_empty' => 'is empty',
        'is_not_empty' => 'is not empty',
    ],

    'results' => [
        'heading' => 'Results',
        'empty' => 'No records match the configured filters.',
        'limit_note' => 'Showing up to :count records.',
    ],

    'actions' => [
        'run' => 'Run Report',
        'export_csv' => 'Export CSV',
    ],

    'navigation' => [
        'label' => 'Reports',
    ],
];
