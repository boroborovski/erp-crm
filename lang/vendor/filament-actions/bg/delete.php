<?php

declare(strict_types=1);

return [
    'single' => [
        'label' => 'Изтрий',
        'modal' => [
            'heading' => 'Изтрий :label',
            'actions' => [
                'delete' => ['label' => 'Изтрий'],
            ],
        ],
        'notifications' => [
            'deleted' => ['title' => 'Изтрит'],
        ],
    ],

    'multiple' => [
        'label' => 'Изтрий избраните',
        'modal' => [
            'heading' => 'Изтрий избраните :label',
            'actions' => [
                'delete' => ['label' => 'Изтрий'],
            ],
        ],
        'notifications' => [
            'deleted' => ['title' => 'Изтрити'],
            'deleted_partial' => [
                'title' => 'Изтрити :count от :total',
                'missing_authorization_failure_message' => 'Нямате разрешение да изтриете :count.',
                'missing_processing_failure_message' => ':count не могат да бъдат изтрити.',
            ],
            'deleted_none' => [
                'title' => 'Неуспешно изтриване',
                'missing_authorization_failure_message' => 'Нямате разрешение да изтриете :count.',
                'missing_processing_failure_message' => ':count не могат да бъдат изтрити.',
            ],
        ],
    ],
];
