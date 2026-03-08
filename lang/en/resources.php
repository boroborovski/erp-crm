<?php

declare(strict_types=1);

return [
    'navigation' => [
        'groups' => [
            'workspace' => 'CRM',
            'tasks' => 'Tasks',
            'erp' => 'ERP',
        ],
    ],

    'models' => [
        'company' => ['singular' => 'Company', 'plural' => 'Companies'],
        'people' => ['singular' => 'Person', 'plural' => 'People'],
        'opportunity' => ['singular' => 'Opportunity', 'plural' => 'Opportunities'],
        'note' => ['singular' => 'Note', 'plural' => 'Notes'],
        'task' => ['singular' => 'Task', 'plural' => 'Tasks'],
        'report' => ['singular' => 'Report', 'plural' => 'Reports'],
        'product' => ['singular' => 'Product', 'plural' => 'Products'],
        'product_category' => ['singular' => 'Product Category', 'plural' => 'Product Categories'],
        'quote' => ['singular' => 'Quote', 'plural' => 'Quotes'],
        'invoice' => ['singular' => 'Invoice', 'plural' => 'Invoices'],
        'project' => ['singular' => 'Project', 'plural' => 'Projects'],
        'milestone' => ['singular' => 'Milestone', 'plural' => 'Milestones'],
    ],

    'columns' => [
        'account_owner' => 'Account Owner',
        'company' => 'Company',
        'contact' => 'Point of Contact',
        'person' => 'Person',
        'created_by' => 'Created By',
        'created_date' => 'Created Date',
        'last_updated' => 'Last Updated',
        'creation_date' => 'Creation Date',
        'last_update' => 'Last Update',
        'creation_source' => 'Creation Source',
        'companies' => 'Companies',
        'people' => 'People',
        'assignees' => 'Assignees',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'assignee' => 'Assignee',
        'title' => 'Title',
    ],

    'fields' => [
        'opportunity_name_placeholder' => 'Enter opportunity title',
    ],

    'filters' => [
        'assigned_to_me' => 'Assigned to me',
        'creation_source' => 'Creation Source',
        'company' => 'Company',
        'contact' => 'Contact',
    ],

    'actions' => [
        'delete_record' => 'Delete record',
        'view_task' => 'View Task',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'copy_page_url' => 'Copy page URL',
        'copy_record_id' => 'Copy record ID',
        'add_task' => 'Add Task',
        'add_opportunity' => 'Add Opportunity',
        'import_companies' => 'Import companies',
        'import_people' => 'Import people',
        'import_opportunities' => 'Import opportunities',
        'import_notes' => 'Import notes',
        'import_tasks' => 'Import tasks',
        'import_export' => 'Import / Export',
        'ai_summary' => 'AI Summary',
        'regenerate' => 'Regenerate',
        'copy' => 'Copy',
        'close' => 'Close',
    ],

    'notifications' => [
        'task_assignment' => 'New Task Assignment: :title',
        'url_copied' => 'URL copied to clipboard',
        'record_id_copied' => 'Record ID copied to clipboard',
        'summary_regenerated' => 'Summary regenerated',
        'summary_failed' => 'Failed to regenerate summary',
        'copied' => 'Copied!',
        'ai_summary_description' => 'AI-generated summary for this :model',
    ],

    'dates' => [
        'overdue' => 'Overdue',
        'due_today' => 'Due Today',
        'due_tomorrow' => 'Due Tomorrow',
    ],

    'pages' => [
        'create_team' => [
            'label' => 'Create Team',
            'heading' => 'Create your workspace',
            'subheading' => 'Choose a name for your team. This will also be used in your workspace URL.',
            'slug_helper' => 'Only lowercase letters, numbers, and hyphens are allowed.',
        ],
    ],

    'exporters' => [
        'columns' => [
            'id' => 'ID',
            'team' => 'Team',
            'company_name' => 'Company Name',
            'opportunity_name' => 'Opportunity Name',
            'contact_person' => 'Contact Person',
            'number_of_people' => 'Number of People',
            'number_of_opportunities' => 'Number of Opportunities',
            'number_of_notes' => 'Number of Notes',
            'number_of_tasks' => 'Number of Tasks',
            'creation_source' => 'Creation Source',
        ],
    ],

    'panel' => [
        'profile' => 'Profile',
        'api_tokens' => 'API Tokens',
        'import_history' => 'Import History',
    ],
];
