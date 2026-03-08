<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Projects',
    ],

    'statuses' => [
        'planning'  => 'Planning',
        'active'    => 'Active',
        'on_hold'   => 'On Hold',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'sections' => [
        'details'    => 'Project Details',
        'progress'   => 'Progress',
        'milestones' => 'Milestones',
        'tasks'      => 'Tasks',
    ],

    'fields' => [
        'name'           => 'Name',
        'description'    => 'Description',
        'status'         => 'Status',
        'start_date'     => 'Start Date',
        'end_date'       => 'End Date',
        'company'        => 'Company',
        'opportunity'    => 'Opportunity',
        'due_date'       => 'Due Date',
        'is_completed'   => 'Completed',
    ],

    'filters' => [
        'status' => 'Status',
    ],

    'actions' => [
        'add_milestone' => 'Add Milestone',
        'add_task'      => 'Add Task',
    ],

    'progress' => [
        'milestones' => ':done / :total milestones completed',
        'tasks'      => ':done / :total tasks completed',
    ],

    'board' => [
        'label' => 'Board',
        'title' => 'Projects',
    ],
];
