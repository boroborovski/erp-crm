<?php

declare(strict_types=1);

return [
    'label' => 'Импортирай :label',

    'modal' => [
        'heading' => 'Импортирай :label',
        'form' => [
            'file' => [
                'label' => 'Файл',
                'placeholder' => 'Качете CSV файл',
                'rules' => [
                    'duplicate_columns' => '{0} Файлът не трябва да съдържа повече от един празен заглавен ред на колона.|{1,*} Файлът не трябва да съдържа дублирани заглавия на колони: :columns.',
                ],
            ],
            'columns' => [
                'label' => 'Колони',
                'placeholder' => 'Изберете колона',
            ],
        ],
        'actions' => [
            'download_example' => ['label' => 'Изтегли примерен CSV файл'],
            'import' => ['label' => 'Импортирай'],
        ],
    ],

    'notifications' => [
        'completed' => [
            'title' => 'Импортът е завършен',
            'actions' => [
                'download_failed_rows_csv' => [
                    'label' => 'Изтегли информация за неуспешния ред|Изтегли информация за неуспешните редове',
                ],
            ],
        ],
        'max_rows' => [
            'title' => 'Качения CSV файл е твърде голям',
            'body' => 'Не можете да импортирате повече от 1 ред наведнъж.|Не можете да импортирате повече от :count реда наведнъж.',
        ],
        'started' => [
            'title' => 'Импортът е започнат',
            'body' => 'Импортът е започнат и 1 ред ще бъде обработен във фонов режим.|Импортът е започнат и :count реда ще бъдат обработени във фонов режим.',
        ],
    ],

    'example_csv' => [
        'file_name' => ':importer-example',
    ],

    'failure_csv' => [
        'file_name' => 'import-:import_id-:csv_name-failed-rows',
        'error_header' => 'грешка',
        'system_error' => 'Системна грешка, моля свържете се с поддръжката.',
        'column_mapping_required_for_new_record' => 'Колоната :attribute не беше свързана с колона от файла, но е задължителна при създаване на нови записи.',
    ],
];
