<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Проекти',
    ],

    'statuses' => [
        'planning'  => 'Планиране',
        'active'    => 'Активен',
        'on_hold'   => 'На пауза',
        'completed' => 'Завършен',
        'cancelled' => 'Отменен',
    ],

    'sections' => [
        'details'    => 'Детайли на проекта',
        'progress'   => 'Напредък',
        'milestones' => 'Етапи',
        'tasks'      => 'Задачи',
    ],

    'fields' => [
        'name'           => 'Наименование',
        'description'    => 'Описание',
        'status'         => 'Статус',
        'start_date'     => 'Начална дата',
        'end_date'       => 'Крайна дата',
        'company'        => 'Компания',
        'opportunity'    => 'Възможност',
        'due_date'       => 'Краен срок',
        'is_completed'   => 'Завършен',
    ],

    'filters' => [
        'status' => 'Статус',
    ],

    'actions' => [
        'add_milestone' => 'Добави етап',
        'add_task'      => 'Добави задача',
    ],

    'progress' => [
        'milestones' => ':done / :total завършени етапи',
        'tasks'      => ':done / :total завършени задачи',
    ],

    'board' => [
        'label' => 'Дъска',
        'title' => 'Проекти',
    ],
];
