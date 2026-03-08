<?php

declare(strict_types=1);

return [
    'title' => 'Потвърдете имейл адреса си',

    'heading' => 'Потвърдете имейл адреса си',

    'actions' => [
        'resend_notification' => [
            'label' => 'Изпрати отново',
        ],
    ],

    'messages' => [
        'notification_not_received' => 'Не сте получили имейла?',
        'notification_sent' => 'Изпратихме имейл до :email с инструкции как да потвърдите имейл адреса си.',
    ],

    'notifications' => [
        'notification_resent' => [
            'title' => 'Имейлът беше изпратен отново.',
        ],
        'notification_resend_throttled' => [
            'title' => 'Твърде много опити за повторно изпращане',
            'body' => 'Моля, опитайте отново след :seconds секунди.',
        ],
    ],
];
