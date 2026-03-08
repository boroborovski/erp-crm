<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Products',
    ],

    'sections' => [
        'basic_info' => 'Basic Information',
        'pricing'    => 'Pricing',
        'stock'      => 'Stock & Inventory',
    ],

    'fields' => [
        'name'        => 'Name',
        'sku'         => 'SKU',
        'description' => 'Description',
        'category'    => 'Category',
        'unit_price'  => 'Unit Price',
        'currency'    => 'Currency',
        'unit'        => 'Unit',
        'is_active'   => 'Active',
    ],

    'units' => [
        'ea'  => 'Each',
        'hr'  => 'Hour',
        'day' => 'Day',
    ],

    'filters' => [
        'category'  => 'Category',
        'is_active' => 'Active Status',
        'min_price' => 'Min Price',
        'max_price' => 'Max Price',
        'low_stock' => 'Low stock only',
    ],

    'bulk_actions' => [
        'activate'   => 'Activate',
        'deactivate' => 'Deactivate',
    ],

    'actions' => [
        'export_csv' => 'Export CSV',
    ],

    'notifications' => [
        'activated'   => 'Products activated.',
        'deactivated' => 'Products deactivated.',
    ],

    'stock' => [
        'movements_heading' => 'Stock Movements',

        'fields' => [
            'track_stock'         => 'Track Stock',
            'stock_quantity'      => 'Stock Quantity',
            'low_stock_threshold' => 'Low Stock Threshold',
            'low_stock_warning'   => 'Low Stock',
            'type'                => 'Type',
            'quantity'            => 'Quantity',
            'note'                => 'Note',
            'created_by'          => 'Recorded By',
        ],

        'movement_types' => [
            'restock'    => 'Restock',
            'adjustment' => 'Adjustment',
            'sale'       => 'Sale',
            'return'     => 'Return',
        ],

        'actions' => [
            'adjust_stock' => 'Adjust Stock',
            'submit'       => 'Save Adjustment',
        ],

        'notifications' => [
            'adjusted' => 'Stock adjusted successfully.',
        ],

        'low_stock_warning' => 'Stock is below the configured threshold.',

        'auto_note_quote'         => 'Auto-deducted for quote :number',
        'auto_note_invoice_void'  => 'Stock reversed — invoice :number voided',
    ],
];
