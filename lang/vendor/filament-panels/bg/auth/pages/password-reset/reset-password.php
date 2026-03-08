<?php

declare(strict_types=1);

return [
    'title' => 'Нулиране на парола',

    'heading' => 'Нулиране на парола',

    'form' => [
        'email' => [
            'label' => 'Имейл адрес',
        ],
        'password' => [
            'label' => 'Парола',
            'validation_attribute' => 'парола',
        ],
        'password_confirmation' => [
            'label' => 'Потвърди паролата',
        ],
        'actions' => [
            'reset' => [
                'label' => 'Нулирай паролата',
            ],
        ],
    ],

    'notifications' => [
        'throttled' => [
            'title' => 'Твърде много опити за нулиране',
            'body' => 'Моля, опитайте отново след :seconds секунди.',
        ],
    ],
];
