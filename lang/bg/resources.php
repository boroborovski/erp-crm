<?php

declare(strict_types=1);

return [
    'navigation' => [
        'groups' => [
            'workspace' => 'CRM',
            'tasks' => 'Задачи',
            'erp' => 'ERP',
        ],
    ],

    'models' => [
        'company' => ['singular' => 'Компания', 'plural' => 'Компании'],
        'people' => ['singular' => 'Контакт', 'plural' => 'Контакти'],
        'opportunity' => ['singular' => 'Възможност', 'plural' => 'Възможности'],
        'note' => ['singular' => 'Бележка', 'plural' => 'Бележки'],
        'task' => ['singular' => 'Задача', 'plural' => 'Задачи'],
        'report' => ['singular' => 'Справка', 'plural' => 'Справки'],
        'product' => ['singular' => 'Продукт', 'plural' => 'Продукти'],
        'product_category' => ['singular' => 'Категория продукти', 'plural' => 'Категории продукти'],
        'quote' => ['singular' => 'Оферта', 'plural' => 'Оферти'],
        'invoice' => ['singular' => 'Фактура', 'plural' => 'Фактури'],
        'project' => ['singular' => 'Проект', 'plural' => 'Проекти'],
        'milestone' => ['singular' => 'Етап', 'plural' => 'Етапи'],
    ],

    'columns' => [
        'account_owner' => 'Отговорник',
        'company' => 'Компания',
        'contact' => 'Отговорен контакт',
        'person' => 'Контакт',
        'created_by' => 'Създаден от',
        'created_date' => 'Дата на създаване',
        'last_updated' => 'Последна промяна',
        'creation_date' => 'Дата на създаване',
        'last_update' => 'Последна промяна',
        'creation_source' => 'Източник',
        'companies' => 'Компании',
        'people' => 'Контакти',
        'assignees' => 'Изпълнители',
        'created_at' => 'Създаден на',
        'updated_at' => 'Обновен на',
        'assignee' => 'Изпълнител',
        'title' => 'Заглавие',
    ],

    'fields' => [
        'opportunity_name_placeholder' => 'Въведете заглавие на възможността',
    ],

    'filters' => [
        'assigned_to_me' => 'Назначени на мен',
        'creation_source' => 'Източник',
        'company' => 'Компания',
        'contact' => 'Контакт',
    ],

    'actions' => [
        'delete_record' => 'Изтрий запис',
        'view_task' => 'Виж задачата',
        'edit' => 'Редактирай',
        'delete' => 'Изтрий',
        'copy_page_url' => 'Копирай URL на страницата',
        'copy_record_id' => 'Копирай ID на записа',
        'add_task' => 'Добави задача',
        'add_opportunity' => 'Добави възможност',
        'import_companies' => 'Импортирай компании',
        'import_people' => 'Импортирай контакти',
        'import_opportunities' => 'Импортирай възможности',
        'import_notes' => 'Импортирай бележки',
        'import_tasks' => 'Импортирай задачи',
        'import_export' => 'Импорт / Експорт',
        'ai_summary' => 'AI Резюме',
        'regenerate' => 'Регенерирай',
        'copy' => 'Копирай',
        'close' => 'Затвори',
    ],

    'notifications' => [
        'task_assignment' => 'Нова задача: :title',
        'url_copied' => 'URL адресът е копиран',
        'record_id_copied' => 'ID на записа е копирано',
        'summary_regenerated' => 'Резюмето е регенерирано',
        'summary_failed' => 'Неуспешно регенериране на резюмето',
        'copied' => 'Копирано!',
        'ai_summary_description' => 'AI-генерирано резюме за този запис',
    ],

    'dates' => [
        'overdue' => 'Просрочено',
        'due_today' => 'Днес',
        'due_tomorrow' => 'Утре',
    ],

    'pages' => [
        'create_team' => [
            'label' => 'Създай екип',
            'heading' => 'Създайте работното си пространство',
            'subheading' => 'Изберете име за вашия екип. То ще се използва и в URL адреса на работното ви пространство.',
            'slug_helper' => 'Разрешени са само малки букви, цифри и тирета.',
        ],
    ],

    'exporters' => [
        'columns' => [
            'id' => 'ID',
            'team' => 'Екип',
            'company_name' => 'Компания',
            'opportunity_name' => 'Възможност',
            'contact_person' => 'Отговорен контакт',
            'number_of_people' => 'Брой контакти',
            'number_of_opportunities' => 'Брой възможности',
            'number_of_notes' => 'Брой бележки',
            'number_of_tasks' => 'Брой задачи',
            'creation_source' => 'Източник',
        ],
    ],

    'panel' => [
        'profile' => 'Профил',
        'api_tokens' => 'API Токени',
        'import_history' => 'История на импорта',
    ],
];
