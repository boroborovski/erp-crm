<?php

declare(strict_types=1);

return [
    'builder' => [
        'actions' => [
            'clone' => ['label' => 'Копирай'],
            'add' => [
                'label' => 'Добави към :label',
                'modal' => [
                    'heading' => 'Добави към :label',
                    'actions' => ['add' => ['label' => 'Добави']],
                ],
            ],
            'add_between' => [
                'label' => 'Вмъкни между блоковете',
                'modal' => [
                    'heading' => 'Добави към :label',
                    'actions' => ['add' => ['label' => 'Добави']],
                ],
            ],
            'delete' => ['label' => 'Изтрий'],
            'edit' => [
                'label' => 'Редактирай',
                'modal' => [
                    'heading' => 'Редактирай блок',
                    'actions' => ['save' => ['label' => 'Запази промените']],
                ],
            ],
            'reorder' => ['label' => 'Премести'],
            'move_down' => ['label' => 'Премести надолу'],
            'move_up' => ['label' => 'Премести нагоре'],
            'collapse' => ['label' => 'Свий'],
            'expand' => ['label' => 'Разгъни'],
            'collapse_all' => ['label' => 'Свий всички'],
            'expand_all' => ['label' => 'Разгъни всички'],
        ],
    ],

    'checkbox_list' => [
        'actions' => [
            'deselect_all' => ['label' => 'Отмени избора'],
            'select_all' => ['label' => 'Избери всички'],
        ],
    ],

    'file_upload' => [
        'editor' => [
            'actions' => [
                'cancel' => ['label' => 'Отмени'],
                'save' => ['label' => 'Запази'],
                'reset' => ['label' => 'Нулирай'],
                'zoom_in' => ['label' => 'Увеличи'],
                'zoom_out' => ['label' => 'Намали'],
                'zoom_100' => ['label' => 'Мащаб 100%'],
                'flip_horizontal' => ['label' => 'Отрази хоризонтално'],
                'flip_vertical' => ['label' => 'Отрази вертикално'],
                'rotate_left' => ['label' => 'Завърти наляво'],
                'rotate_right' => ['label' => 'Завърти надясно'],
                'move_up' => ['label' => 'Премести нагоре'],
                'move_down' => ['label' => 'Премести надолу'],
                'move_left' => ['label' => 'Премести наляво'],
                'move_right' => ['label' => 'Премести надясно'],
                'drag_crop' => ['label' => 'Режим на плъзгане "изрязване"'],
                'drag_move' => ['label' => 'Режим на плъзгане "преместване"'],
                'set_aspect_ratio' => ['label' => 'Задай пропорция :ratio'],
            ],
            'fields' => [
                'height' => ['label' => 'Височина', 'unit' => 'пx'],
                'rotation' => ['label' => 'Завъртане', 'unit' => 'градуса'],
                'width' => ['label' => 'Ширина', 'unit' => 'пx'],
                'x_position' => ['label' => 'X', 'unit' => 'пx'],
                'y_position' => ['label' => 'Y', 'unit' => 'пx'],
            ],
            'aspect_ratios' => [
                'label' => 'Пропорции',
                'no_fixed' => ['label' => 'Свободно'],
            ],
        ],
    ],

    'key_value' => [
        'actions' => [
            'add' => ['label' => 'Добави ред'],
            'delete' => ['label' => 'Изтрий ред'],
            'reorder' => ['label' => 'Пренареди ред'],
        ],
        'fields' => [
            'key' => ['label' => 'Ключ'],
            'value' => ['label' => 'Стойност'],
        ],
    ],

    'markdown_editor' => [
        'tools' => [
            'attach_files' => 'Прикачи файлове',
            'blockquote' => 'Цитат',
            'bold' => 'Удебелен',
            'bullet_list' => 'Списък с точки',
            'code_block' => 'Блок с код',
            'heading' => 'Заглавие',
            'italic' => 'Курсив',
            'link' => 'Връзка',
            'ordered_list' => 'Номериран списък',
            'redo' => 'Повтори',
            'strike' => 'Зачертан',
            'table' => 'Таблица',
            'undo' => 'Отмени',
        ],
    ],

    'radio' => [
        'boolean' => ['true' => 'Да', 'false' => 'Не'],
    ],

    'repeater' => [
        'actions' => [
            'add' => ['label' => 'Добави към :label'],
            'add_between' => ['label' => 'Вмъкни между'],
            'delete' => ['label' => 'Изтрий'],
            'clone' => ['label' => 'Копирай'],
            'reorder' => ['label' => 'Премести'],
            'move_down' => ['label' => 'Премести надолу'],
            'move_up' => ['label' => 'Премести нагоре'],
            'collapse' => ['label' => 'Свий'],
            'expand' => ['label' => 'Разгъни'],
            'collapse_all' => ['label' => 'Свий всички'],
            'expand_all' => ['label' => 'Разгъни всички'],
        ],
    ],

    'select' => [
        'actions' => [
            'create_option' => [
                'label' => 'Създай',
                'modal' => [
                    'heading' => 'Създай',
                    'actions' => [
                        'create' => ['label' => 'Създай'],
                        'create_another' => ['label' => 'Създай и добави друг'],
                    ],
                ],
            ],
            'edit_option' => [
                'label' => 'Редактирай',
                'modal' => [
                    'heading' => 'Редактирай',
                    'actions' => ['save' => ['label' => 'Запази']],
                ],
            ],
        ],
        'boolean' => ['true' => 'Да', 'false' => 'Не'],
        'loading_message' => 'Зареждане...',
        'max_items_message' => 'Можете да изберете най-много :count.',
        'no_options_message' => 'Няма налични опции.',
        'no_search_results_message' => 'Няма съответстващи опции.',
        'placeholder' => 'Изберете опция',
        'searching_message' => 'Търсене...',
        'search_prompt' => 'Започнете да пишете за търсене...',
    ],

    'tags_input' => [
        'actions' => [
            'delete' => ['label' => 'Изтрий'],
        ],
        'placeholder' => 'Нов етикет',
    ],

    'text_input' => [
        'actions' => [
            'copy' => ['label' => 'Копирай', 'message' => 'Копирано'],
            'hide_password' => ['label' => 'Скрий паролата'],
            'show_password' => ['label' => 'Покажи паролата'],
        ],
    ],

    'toggle_buttons' => [
        'boolean' => ['true' => 'Да', 'false' => 'Не'],
    ],
];
