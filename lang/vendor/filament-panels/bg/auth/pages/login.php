<?php

declare(strict_types=1);

return [
    'title' => 'Вход',

    'heading' => 'Влезте в акаунта си',

    'actions' => [
        'register' => [
            'before' => 'или',
            'label' => 'създайте акаунт',
        ],
        'request_password_reset' => [
            'label' => 'Забравена парола?',
        ],
    ],

    'form' => [
        'email' => [
            'label' => 'Имейл адрес',
        ],
        'password' => [
            'label' => 'Парола',
        ],
        'remember' => [
            'label' => 'Запомни ме',
        ],
        'actions' => [
            'authenticate' => [
                'label' => 'Вход',
            ],
        ],
    ],

    'messages' => [
        'failed' => 'Тези данни не съвпадат с нашите записи.',
    ],

    'notifications' => [
        'throttled' => [
            'title' => 'Твърде много опити за вход',
            'body' => 'Моля, опитайте отново след :seconds секунди.',
        ],
    ],
];
