<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Продукти',
    ],

    'sections' => [
        'basic_info' => 'Основна информация',
        'pricing'    => 'Ценообразуване',
        'stock'      => 'Склад и инвентар',
    ],

    'fields' => [
        'name'        => 'Наименование',
        'sku'         => 'Артикулен номер',
        'description' => 'Описание',
        'category'    => 'Категория',
        'unit_price'  => 'Единична цена',
        'currency'    => 'Валута',
        'unit'        => 'Мерна единица',
        'is_active'   => 'Активен',
    ],

    'units' => [
        'ea'  => 'Брой',
        'hr'  => 'Час',
        'day' => 'Ден',
    ],

    'filters' => [
        'category'  => 'Категория',
        'is_active' => 'Статус',
        'min_price' => 'Мин. цена',
        'max_price' => 'Макс. цена',
        'low_stock' => 'Само ниски наличности',
    ],

    'bulk_actions' => [
        'activate'   => 'Активирай',
        'deactivate' => 'Деактивирай',
    ],

    'actions' => [
        'export_csv' => 'Експорт CSV',
    ],

    'notifications' => [
        'activated'   => 'Продуктите са активирани.',
        'deactivated' => 'Продуктите са деактивирани.',
    ],

    'stock' => [
        'movements_heading' => 'Складови движения',

        'fields' => [
            'track_stock'         => 'Проследяване на склада',
            'stock_quantity'      => 'Налично количество',
            'low_stock_threshold' => 'Праг за ниска наличност',
            'low_stock_warning'   => 'Ниска наличност',
            'type'                => 'Тип',
            'quantity'            => 'Количество',
            'note'                => 'Бележка',
            'created_by'          => 'Записано от',
        ],

        'movement_types' => [
            'restock'    => 'Зареждане',
            'adjustment' => 'Корекция',
            'sale'       => 'Продажба',
            'return'     => 'Връщане',
        ],

        'actions' => [
            'adjust_stock' => 'Корекция на склада',
            'submit'       => 'Запази корекцията',
        ],

        'notifications' => [
            'adjusted' => 'Складът е коригиран успешно.',
        ],

        'low_stock_warning' => 'Наличността е под зададения праг.',

        'auto_note_quote'        => 'Автоматично приспадане за оферта :number',
        'auto_note_invoice_void' => 'Върнато количество — фактура :number анулирана',
    ],
];
