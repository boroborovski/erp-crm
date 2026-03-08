<?php

declare(strict_types=1);

return [
    'title' => 'Регистрация',

    'heading' => 'Създайте акаунт',

    'actions' => [
        'login' => [
            'before' => 'или',
            'label' => 'влезте в акаунта си',
        ],
    ],

    'form' => [
        'email' => [
            'label' => 'Имейл адрес',
        ],
        'name' => [
            'label' => 'Имe',
        ],
        'password' => [
            'label' => 'Парола',
            'validation_attribute' => 'парола',
        ],
        'password_confirmation' => [
            'label' => 'Потвърди паролата',
        ],
        'actions' => [
            'register' => [
                'label' => 'Регистрация',
            ],
        ],
    ],

    'notifications' => [
        'throttled' => [
            'title' => 'Твърде много опити за регистрация',
            'body' => 'Моля, опитайте отново след :seconds секунди.',
        ],
    ],
];
