<?php

declare(strict_types=1);

return [
    'builder' => [
        'heading' => 'Конструктор на справки',
        'fields' => [
            'name' => 'Име на справката',
            'description' => 'Описание',
            'entity' => 'Източник на данни',
            'columns' => 'Колони за показване',
            'filters' => 'Условия за филтриране',
            'filter_field' => 'Поле',
            'filter_operator' => 'Условие',
            'filter_value' => 'Стойност',
        ],
        'add_filter' => 'Добави филтър',
        'no_columns_hint' => 'Изберете първо източник на данни.',
    ],

    'columns' => [
        'name' => 'Име',
        'phone' => 'Телефон',
        'address' => 'Адрес',
        'country' => 'Държава',
        'company' => 'Компания',
        'contact' => 'Контакт',
        'created_at' => 'Създаден на',
    ],

    'operators' => [
        'equals' => 'равно на',
        'not_equals' => 'различно от',
        'contains' => 'съдържа',
        'starts_with' => 'започва с',
        'greater_than' => 'по-голямо от',
        'less_than' => 'по-малко от',
        'is_empty' => 'е празно',
        'is_not_empty' => 'не е празно',
    ],

    'results' => [
        'heading' => 'Резултати',
        'empty' => 'Няма записи, отговарящи на зададените условия.',
        'limit_note' => 'Показват се до :count записа.',
    ],

    'actions' => [
        'run' => 'Изпълни справката',
        'export_csv' => 'Експортирай CSV',
    ],

    'navigation' => [
        'label' => 'Справки',
    ],
];
