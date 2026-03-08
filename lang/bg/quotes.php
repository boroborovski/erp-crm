<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Оферти',
    ],

    'statuses' => [
        'draft'    => 'Чернова',
        'sent'     => 'Изпратена',
        'accepted' => 'Приета',
        'rejected' => 'Отхвърлена',
        'expired'  => 'Изтекла',
    ],

    'sections' => [
        'details'    => 'Детайли на офертата',
        'line_items' => 'Позиции',
        'notes'      => 'Бележки',
    ],

    'fields' => [
        'quote_number'             => 'Номер на оферта',
        'quote_number_placeholder' => 'Автоматично при запис',
        'status'                   => 'Статус',
        'opportunity'              => 'Възможност',
        'company'                  => 'Компания',
        'contact'                  => 'Контакт',
        'valid_until'              => 'Валидна до',
        'notes'                    => 'Бележки',
        'product'                  => 'Продукт',
        'description'              => 'Описание',
        'quantity'                 => 'Количество',
        'unit_price'               => 'Единична цена',
        'discount_pct'             => 'Отстъпка',
        'tax_pct'                  => 'ДДС',
        'line_total'               => 'Общо',
        'subtotal'                 => 'Подобщо',
        'total_tax'                => 'Данъци',
        'grand_total'              => 'Крайна сума',
    ],

    'actions' => [
        'add_line_item' => 'Добави позиция',
        'download_pdf'  => 'Изтегли PDF',
        'send_quote'    => 'Изпрати оферта',
    ],

    'email' => [
        'default_subject' => 'Оферта :number от :team',
        'default_body'    => '<p>Моля, намерете приложена оферта <strong>:number</strong> от <strong>:team</strong>.</p><p>При въпроси, не се колебайте да се свържете с нас.</p><p>С уважение,<br>:team</p>',
    ],

    'filters' => [
        'status' => 'Статус',
    ],
];
