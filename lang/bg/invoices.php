<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Фактури',
    ],

    'statuses' => [
        'draft'   => 'Чернова',
        'issued'  => 'Издадена',
        'partial' => 'Частично платена',
        'paid'    => 'Платена',
        'overdue' => 'Просрочена',
        'void'    => 'Анулирана',
    ],

    'payment_methods' => [
        'bank'  => 'Банков превод',
        'card'  => 'Карта',
        'cash'  => 'Кеш',
        'other' => 'Друго',
    ],

    'sections' => [
        'details'    => 'Детайли на фактурата',
        'line_items' => 'Позиции',
        'payments'   => 'Плащания',
        'notes'      => 'Бележки',
    ],

    'fields' => [
        'invoice_number'             => 'Номер на фактура',
        'invoice_number_placeholder' => 'Автоматично при запис',
        'status'                     => 'Статус',
        'quote'                      => 'Оферта',
        'company'                    => 'Компания',
        'contact'                    => 'Контакт',
        'issue_date'                 => 'Дата на издаване',
        'due_date'                   => 'Дата на падеж',
        'notes'                      => 'Бележки',
        'product'                    => 'Продукт',
        'description'                => 'Описание',
        'quantity'                   => 'Количество',
        'unit_price'                 => 'Единична цена',
        'discount_pct'               => 'Отстъпка',
        'tax_pct'                    => 'ДДС',
        'line_total'                 => 'Общо',
        'subtotal'                   => 'Подобщо',
        'total_tax'                  => 'Данъци',
        'grand_total'                => 'Крайна сума',
        'amount_paid'                => 'Платена сума',
        'amount_outstanding'         => 'Остатък',
        'amount'                     => 'Сума',
        'paid_at'                    => 'Дата на плащане',
        'method'                     => 'Метод',
        'reference'                  => 'Референция',
    ],

    'actions' => [
        'add_line_item'       => 'Добави позиция',
        'download_pdf'        => 'Изтегли PDF',
        'send_invoice'        => 'Изпрати фактура',
        'record_payment'      => 'Запиши плащане',
        'void_invoice'        => 'Анулирай фактура',
        'void_confirm'        => 'Сигурни ли сте, че искате да анулирате тази фактура?',
        'convert_to_invoice'  => 'Конвертирай в фактура',
    ],

    'email' => [
        'default_subject' => 'Фактура :number от :team',
        'default_body'    => '<p>Моля, намерете приложена фактура <strong>:number</strong> от <strong>:team</strong>.</p><p>При въпроси, не се колебайте да се свържете с нас.</p><p>С уважение,<br>:team</p>',
    ],

    'filters' => [
        'status' => 'Статус',
    ],

    'widgets' => [
        'heading'              => 'Преглед на фактурите (Текущ месец)',
        'total_invoiced'       => 'Общо фактурирано',
        'total_paid'           => 'Общо платено',
        'outstanding_balance'  => 'Непогасен остатък',
    ],
];
