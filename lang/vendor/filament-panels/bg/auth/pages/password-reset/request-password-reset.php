<?php

declare(strict_types=1);

return [
    'title' => 'Нулиране на парола',

    'heading' => 'Забравена парола?',

    'actions' => [
        'login' => [
            'label' => 'обратно към вход',
        ],
    ],

    'form' => [
        'email' => [
            'label' => 'Имейл адрес',
        ],
        'actions' => [
            'request' => [
                'label' => 'Изпрати имейл',
            ],
        ],
    ],

    'notifications' => [
        'sent' => [
            'body' => 'Ако акаунтът ви съществува, ще получите имейл с инструкции.',
        ],
        'throttled' => [
            'title' => 'Твърде много заявки',
            'body' => 'Моля, опитайте отново след :seconds секунди.',
        ],
    ],
];
