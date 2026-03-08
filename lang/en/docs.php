<?php

declare(strict_types=1);

return [
    'nav_title'          => 'Documentation',
    'search_placeholder' => 'Search docs...',
    'on_this_page'       => 'On this page',
    'back_to_top'        => 'Back to top',
    'tip'                => 'Tip',
    'note'               => 'Note',
    'prev_page'          => 'Previous',
    'next_page'          => 'Next',

    'sections' => [
        'getting_started' => 'Getting Started',
        'crm'             => 'CRM',
        'erp'             => 'ERP',
        'configuration'   => 'Configuration',
    ],

    'pages' => [

        'getting-started' => [
            'title'     => 'Getting Started',
            'nav_label' => 'Getting Started',
            'intro'     => 'Welcome to Relaticle — a complete CRM & ERP platform. This guide walks you through your first steps: logging in, setting up your workspace, and personalising your account.',

            'login' => [
                'heading' => 'Logging In',
                'body'    => 'Navigate to your Relaticle instance URL and click Login. You can sign in using your email and password or via a connected social provider (Google, GitHub) if configured by your administrator.',
                'steps'   => [
                    'Open your browser and go to your Relaticle URL.',
                    'Enter your registered email address and password.',
                    'Click the Login button to enter the application.',
                    'If you have forgotten your password, click Forgot Password and follow the reset instructions sent to your email.',
                ],
            ],

            'workspaces' => [
                'heading' => 'Workspaces (Teams)',
                'body'    => 'Relaticle organises your data into workspaces, also called teams. Each workspace has its own companies, contacts, pipeline, and settings. You can belong to multiple workspaces and switch between them at any time.',
                'create_steps' => [
                    'Click your workspace name in the top navigation bar.',
                    'Select Create New Team from the dropdown.',
                    'Enter a team name and click Create Team.',
                    'You are automatically set as the owner of the new workspace.',
                ],
                'switch_steps' => [
                    'Click your workspace name in the top navigation bar.',
                    'Under Switch Teams, choose the workspace you want to switch to.',
                    'The page reloads showing that workspace\'s data.',
                ],
                'invite_tip' => 'To invite colleagues, go to your workspace settings, click Team Members, enter their email address, and select their role.',
            ],

            'profile' => [
                'heading' => 'Profile Settings',
                'body'    => 'Your profile holds your personal details and preferences. You can update your name, email, profile photo, and language at any time.',
                'steps'   => [
                    'Click your avatar or name in the top-right corner.',
                    'Select Profile from the dropdown menu.',
                    'Update your name, email, or profile photo in the Profile Information section.',
                    'Click Save to apply your changes.',
                ],
            ],

            'locale' => [
                'heading' => 'Switching Language',
                'body'    => 'Relaticle supports English and Bulgarian. You can switch the application language from the public header (EN / BG toggle) or by setting your preferred language in your profile.',
                'steps'   => [
                    'On the public landing page or documentation pages, click EN or BG in the header to switch the display language immediately.',
                    'To make the language preference permanent inside the application, go to your Profile page.',
                    'Find the Language field and choose your preferred language.',
                    'Click Save — the application will now always display in your chosen language when you are logged in.',
                ],
                'tip' => 'The language selection on the landing page is stored in your session. Logging in and setting it in your Profile persists it to your account permanently.',
            ],
        ],

        'companies' => [
            'title'     => 'Companies',
            'nav_label' => 'Companies',
            'intro'     => 'Companies represent the organisations you do business with. Each company record holds contact details, linked people, notes, tasks, emails, and a full activity timeline.',

            'creating' => [
                'heading' => 'Creating a Company',
                'steps'   => [
                    'In the left sidebar, click Companies.',
                    'Click the New Company button in the top-right corner.',
                    'Fill in the company name (required), website, industry, and any other details.',
                    'Click Create to save the record.',
                ],
                'tip' => 'Use the Import feature (top-right toolbar) to bulk-create companies from a CSV file.',
            ],

            'editing' => [
                'heading' => 'Editing a Company',
                'steps'   => [
                    'Open the company record by clicking its name in the list.',
                    'Click the Edit button (pencil icon) or the Edit action in the top-right toolbar.',
                    'Update the fields you need to change.',
                    'Click Save to apply your changes.',
                ],
            ],

            'custom_fields' => [
                'heading' => 'Custom Fields',
                'body'    => 'You can attach custom fields to a company record to track industry-specific data such as contract numbers, account tiers, or any other information your business needs.',
                'steps'   => [
                    'Open the company record.',
                    'Scroll to the Custom Fields section on the edit form.',
                    'Fill in or update the values for any custom fields already defined.',
                ],
                'note' => 'Custom field definitions are managed by your workspace administrator through the Custom Fields settings area.',
            ],

            'activity' => [
                'heading' => 'Activity Timeline',
                'body'    => 'Every change, note, task, and email associated with a company is recorded in its activity timeline. Open a company record and scroll to the Timeline section at the bottom of the view page to see the full history in chronological order.',
            ],

            'emails' => [
                'heading' => 'Sending Emails',
                'steps'   => [
                    'Open the company record.',
                    'Click the Send Email action button in the top-right toolbar.',
                    'Enter the recipient address, subject, and message body.',
                    'Click Send — the email is delivered and saved to the Email Thread section.',
                ],
            ],

            'quotes_invoices' => [
                'heading' => 'Quotes & Invoices',
                'body'    => 'When ERP is enabled for your workspace, Quotes and Invoices linked to a company appear in dedicated relation tabs on the company view page. Click any record to open it or use the Create button within the tab to add a new one directly linked to this company.',
            ],
        ],

        'people' => [
            'title'     => 'People',
            'nav_label' => 'People',
            'intro'     => 'People are the individual contacts you interact with. They can be linked to companies and appear on a company\'s profile as associated contacts.',

            'adding' => [
                'heading' => 'Adding a Contact',
                'steps'   => [
                    'In the left sidebar, click People.',
                    'Click the New Person button in the top-right corner.',
                    'Enter the person\'s first name, last name, and email address.',
                    'Optionally, link them to a company using the Company field.',
                    'Click Create to save.',
                ],
            ],

            'linking' => [
                'heading' => 'Linking to a Company',
                'body'    => 'You can link a person to a company either when creating or editing their record. Once linked, the person appears in the People tab of that company\'s view page.',
                'steps'   => [
                    'Open the person record.',
                    'Click Edit.',
                    'In the Company field, start typing the company name and select it from the dropdown.',
                    'Click Save.',
                ],
                'tip' => 'A person can only be linked to one company at a time. To move them, simply update the Company field.',
            ],

            'email_thread' => [
                'heading' => 'Email Thread',
                'body'    => 'All emails sent to or received from a contact are shown in the Email Thread section on their view page. You can reply, compose a new email, or review the full conversation history — all without leaving the contact record.',
            ],

            'activity' => [
                'heading' => 'Activity Timeline',
                'body'    => 'The activity timeline on each person\'s view page shows a chronological log of all recorded interactions: when they were added, any updates, notes, tasks, and emails. This gives you instant context before any call or meeting.',
            ],
        ],

        'opportunities' => [
            'title'     => 'Opportunities',
            'nav_label' => 'Opportunities',
            'intro'     => 'Opportunities represent potential deals in your sales pipeline. Track each deal through custom stages and manage your entire pipeline using the Kanban board.',

            'creating' => [
                'heading' => 'Creating an Opportunity',
                'steps'   => [
                    'In the left sidebar, click Opportunities.',
                    'Click the New Opportunity button.',
                    'Enter a name for the opportunity, its estimated value, and the associated company or contact.',
                    'Select the pipeline stage this deal is currently in.',
                    'Click Create.',
                ],
            ],

            'pipeline' => [
                'heading' => 'Pipeline Stages',
                'body'    => 'Pipeline stages represent the steps in your sales process (for example: Lead, Qualified, Proposal, Negotiation, Won, Lost). Each opportunity lives in exactly one stage. You can move opportunities between stages manually or drag-and-drop them on the Kanban board.',
                'steps'   => [
                    'Open the opportunity record.',
                    'Click the current stage badge at the top of the record.',
                    'Select the new stage from the dropdown.',
                    'Click Save to confirm the move.',
                ],
            ],

            'kanban' => [
                'heading' => 'Kanban Board',
                'body'    => 'The Kanban board gives you a visual overview of all your opportunities grouped by pipeline stage.',
                'steps'   => [
                    'In the Opportunities section, click the Board tab (or the Kanban icon).',
                    'Each column represents a pipeline stage.',
                    'Drag an opportunity card from one column to another to change its stage.',
                    'Click any card to open the full opportunity record.',
                ],
                'tip' => 'Use the filter controls above the board to narrow down deals by owner, company, or value range.',
            ],

            'quotes' => [
                'heading' => 'Linking Quotes',
                'body'    => 'When ERP is enabled, you can create quotes directly from an opportunity. Open the opportunity record and use the Quotes tab to create or link existing quotes. Accepted quotes can be converted to invoices in one click.',
            ],
        ],

        'tasks' => [
            'title'     => 'Tasks',
            'nav_label' => 'Tasks',
            'intro'     => 'Tasks help you track action items across your CRM records and projects. You can view all tasks in the dedicated Tasks section or manage them from within a specific company, person, opportunity, or project record.',

            'creating' => [
                'heading' => 'Creating a Task',
                'steps'   => [
                    'In the left sidebar, click Tasks.',
                    'Click the New Task button.',
                    'Enter a title and optional description.',
                    'Set a due date and assign it to a team member if needed.',
                    'Optionally link the task to a company, person, or opportunity.',
                    'Click Create.',
                ],
                'tip' => 'You can also create tasks directly from within a company, person, or opportunity record using the Tasks relation tab — the link is set automatically.',
            ],

            'kanban' => [
                'heading' => 'Task Kanban Board',
                'body'    => 'The task Kanban board shows your tasks organised by status column. Use it to get a quick overview of what is pending, in progress, and done.',
                'steps'   => [
                    'Click the Board view tab in the Tasks section.',
                    'Drag tasks between columns to update their status.',
                    'Click any card to open the task and edit details.',
                ],
            ],

            'projects' => [
                'heading' => 'Linking Tasks to Projects',
                'body'    => 'When ERP is enabled, tasks can be linked to a project. This allows you to group related work together and track progress at the project level.',
                'steps'   => [
                    'Open the task record (or create a new one).',
                    'Find the Project field.',
                    'Start typing the project name and select it from the dropdown.',
                    'Click Save.',
                ],
            ],
        ],

        'notes' => [
            'title'     => 'Notes',
            'nav_label' => 'Notes',
            'intro'     => 'Notes let you capture free-form context about companies, people, and opportunities — meeting summaries, call outcomes, research findings, or anything else worth recording.',

            'adding' => [
                'heading' => 'Adding a Note',
                'steps'   => [
                    'Open a company, person, or opportunity record.',
                    'In the Notes section of the view page, click Add Note.',
                    'Type your note in the text area.',
                    'Click Save Note.',
                ],
                'tip' => 'Notes are added to the activity timeline automatically so you always have a full audit trail.',
            ],

            'managing' => [
                'heading' => 'Managing Notes',
                'body'    => 'You can view all notes in the Notes section of any record. Each note shows who created it and when. To edit or delete a note, hover over it to reveal the action icons.',
                'steps'   => [
                    'In the left sidebar, click Notes to see all notes across your workspace.',
                    'Use the search and filter toolbar to find notes by keyword or related record.',
                    'Click a note\'s row to open the related record.',
                ],
            ],

            'linked' => [
                'heading' => 'Notes on Multiple Records',
                'body'    => 'A single note can be linked to a company, a person, and an opportunity simultaneously. When creating a note from the Notes list page, you can choose which records to associate it with using the relation fields.',
            ],
        ],

        'activity-timeline' => [
            'title'     => 'Activity Timeline',
            'nav_label' => 'Activity Timeline',
            'intro'     => 'The Activity Timeline is an automatic chronological log of everything that has happened on a company, person, or opportunity record. It provides instant context and a complete audit trail without any extra effort.',

            'events' => [
                'heading' => 'What Events Are Logged',
                'body'    => 'The following events are recorded automatically:',
                'items'   => [
                    'Created — when a record is first saved.',
                    'Updated — when any field on the record is changed.',
                    'Note Added — when a note is attached to the record.',
                    'Task Added — when a task is linked to the record.',
                    'Email Sent — when an outbound email is sent from the record.',
                ],
                'note' => 'Inbound emails that are automatically matched to a contact also appear in the timeline.',
            ],

            'reading' => [
                'heading' => 'Reading the Timeline',
                'body'    => 'Open any company, person, or opportunity record and scroll down to the Timeline section. Each entry shows:',
                'items'   => [
                    'The event type icon.',
                    'A description of what happened.',
                    'The name of the team member who performed the action.',
                    'The date and time of the event.',
                ],
            ],

            'filtering' => [
                'heading' => 'Filtering the Timeline',
                'body'    => 'The timeline displays all events in reverse chronological order (newest first). At present, all event types are shown together. Use the notes and tasks relation tabs on the same record page to view those items in isolation.',
            ],
        ],

        'email-integration' => [
            'title'     => 'Email Integration',
            'nav_label' => 'Email Integration',
            'intro'     => 'Relaticle can send emails from within any company or person record and can automatically fetch inbound emails from a configured IMAP mailbox — keeping your email conversations stored alongside your CRM data.',

            'imap_setup' => [
                'heading' => 'IMAP Setup',
                'body'    => 'To enable inbound email polling, configure the following environment variables in your server\'s .env file:',
                'vars'    => [
                    'IMAP_HOST — The hostname of your IMAP server (e.g. imap.gmail.com).',
                    'IMAP_PORT — The IMAP port number (e.g. 993 for SSL).',
                    'IMAP_USERNAME — The full email address used to connect.',
                    'IMAP_PASSWORD — The password or app-specific password for that account.',
                    'IMAP_ENCRYPTION — The encryption method: ssl or tls.',
                ],
                'note' => 'If IMAP_HOST is not set, inbound polling is disabled and the application operates in outbound-only mode. The PHP imap extension must be enabled on the server.',
                'after' => 'After setting these variables, restart your queue workers. The application polls for new mail every 5 minutes via the scheduler.',
            ],

            'composing' => [
                'heading' => 'Composing Emails from a Record',
                'steps'   => [
                    'Open a company or person record.',
                    'Click the Send Email button in the record\'s action toolbar.',
                    'Enter the recipient address (pre-filled from the contact\'s email field if available), subject, and message body.',
                    'Click Send.',
                    'The email is delivered via your configured MAIL_MAILER and saved to the record\'s Email Thread.',
                ],
                'tip' => 'Sent emails also appear in the activity timeline as an "Email Sent" event.',
            ],

            'inbound' => [
                'heading' => 'Inbound Email Matching',
                'body'    => 'When the scheduler polls the IMAP mailbox, each new email is processed as follows:',
                'steps'   => [
                    'The application reads the sender\'s email address.',
                    'It searches the People records in your workspace for a contact whose email custom field matches the sender\'s address.',
                    'If a match is found, the email is saved and linked to that person (and their associated company if one exists).',
                    'If no match is found, the email is still saved but is stored without a subject link.',
                ],
                'note' => 'Duplicate prevention: each email is identified by its Message-ID header. An email with the same Message-ID is never imported twice.',
            ],
        ],

        'custom-reports' => [
            'title'     => 'Custom Reports',
            'nav_label' => 'Custom Reports',
            'intro'     => 'The Custom Reports feature lets you build tabular reports from your CRM data without writing any code. Choose an entity, select the columns you want to see, add filter conditions, and run the report instantly.',

            'building' => [
                'heading' => 'Building a Report',
                'steps'   => [
                    'In the left sidebar, click Reports.',
                    'Click New Report.',
                    'Enter a name and optional description for the report.',
                    'Choose the Entity: Companies, People, or Opportunities.',
                    'In the Columns section, select which fields to include as columns in the results table.',
                    'Optionally add Filter Conditions (see below).',
                    'Click Create to save and run the report.',
                ],
            ],

            'filters' => [
                'heading' => 'Adding Filter Conditions',
                'body'    => 'Filters narrow the report results to records that match your criteria.',
                'steps'   => [
                    'In the report form, scroll to the Filters section and click Add Filter.',
                    'Choose the field to filter on (e.g. Industry, Name, Value).',
                    'Choose the operator: equals, not equals, contains, starts with, greater than, less than, is empty, is not empty.',
                    'Enter the comparison value (where applicable).',
                    'Add multiple filters to combine conditions — all must match.',
                ],
                'tip' => 'Leave the filters section empty to return all records of the chosen entity.',
            ],

            'running' => [
                'heading' => 'Running and Exporting a Report',
                'body'    => 'When you open a saved report (View page), the results table is generated and displayed automatically.',
                'steps'   => [
                    'Click the report name in the Reports list.',
                    'The results table loads showing up to 500 rows.',
                    'To export, click the Export CSV button in the top toolbar.',
                    'A CSV file is downloaded to your computer immediately — no server upload required.',
                ],
                'note' => 'Reports are capped at 500 rows to maintain performance. If you need more rows, refine your filters to narrow the results.',
            ],
        ],

        'products' => [
            'title'     => 'Products & Catalog',
            'nav_label' => 'Products & Catalog',
            'intro'     => 'The Products & Catalog module (ERP) lets you maintain a central list of the products and services you sell, with pricing, categories, and units. This catalog is used when creating quotes and invoices.',

            'creating' => [
                'heading' => 'Creating a Product',
                'steps'   => [
                    'In the left sidebar under the ERP section, click Products.',
                    'Click New Product.',
                    'Enter the product name, SKU (optional), and description.',
                    'Set the unit price and select the currency.',
                    'Choose the unit type: ea (each), hr (hour), or day.',
                    'Optionally assign the product to a category.',
                    'Click Create.',
                ],
                'tip' => 'New categories can be created inline by typing a new name in the Category field and clicking Create.',
            ],

            'categories' => [
                'heading' => 'Product Categories',
                'body'    => 'Categories help you organise your catalog. They support a parent-child hierarchy — for example, a "Software" parent category with "Licences" and "Support" sub-categories.',
                'steps'   => [
                    'When creating or editing a product, click the Category dropdown.',
                    'Start typing a new category name.',
                    'Click Create to create the category on the fly.',
                    'Existing categories are listed — select one to assign the product.',
                ],
            ],

            'units' => [
                'heading' => 'Units',
                'body'    => 'Each product has a billing unit that determines how line item quantities are described on quotes and invoices:',
                'items'   => [
                    'ea — Each (used for physical products or one-off services).',
                    'hr — Hour (used for time-based services).',
                    'day — Day (used for day-rate engagements).',
                ],
            ],

            'active' => [
                'heading' => 'Activating and Deactivating Products',
                'body'    => 'Products can be set as active or inactive. Only active products appear in the line item picker when creating quotes and invoices.',
                'steps'   => [
                    'In the Products list, tick the checkbox next to one or more products.',
                    'Click Bulk Actions and select Activate or Deactivate.',
                    'Alternatively, open a product and toggle the Active switch on the edit form.',
                ],
            ],
        ],

        'quotes' => [
            'title'     => 'Quotes & Proposals',
            'nav_label' => 'Quotes & Proposals',
            'intro'     => 'The Quotes module (ERP) allows you to create professional proposals for your customers, add line items from your product catalog, export them to PDF, and track their status through your workflow.',

            'creating' => [
                'heading' => 'Creating a Quote',
                'steps'   => [
                    'In the left sidebar under ERP, click Quotes.',
                    'Click New Quote.',
                    'Select the company and optionally the opportunity this quote relates to.',
                    'Add line items by clicking Add Item — search for a product or enter a custom description.',
                    'Set quantities and adjust unit prices if needed.',
                    'Add notes or terms in the Notes field.',
                    'Click Create.',
                ],
                'tip' => 'The quote total is calculated automatically from the line items. You can override the unit price on any line item.',
            ],

            'status' => [
                'heading' => 'Quote Status Workflow',
                'body'    => 'A quote moves through the following statuses:',
                'items'   => [
                    'Draft — the default state; the quote is still being prepared.',
                    'Sent — the quote has been sent to the customer.',
                    'Accepted — the customer has accepted the proposal.',
                    'Rejected — the customer has declined the proposal.',
                    'Expired — the quote\'s validity date has passed.',
                ],
                'steps'   => [
                    'Open the quote record.',
                    'Use the status action buttons in the toolbar to move it forward.',
                ],
            ],

            'pdf' => [
                'heading' => 'Exporting to PDF',
                'steps'   => [
                    'Open the quote record.',
                    'Click the Export PDF button in the action toolbar.',
                    'A PDF is generated and downloaded to your browser automatically.',
                ],
            ],

            'convert' => [
                'heading' => 'Converting to an Invoice',
                'body'    => 'Once a quote is accepted, you can convert it to an invoice with a single action.',
                'steps'   => [
                    'Open an accepted quote.',
                    'Click the Convert to Invoice button in the toolbar.',
                    'A new invoice is created with all line items pre-populated.',
                    'Review and adjust the invoice if needed, then issue it.',
                ],
                'note' => 'The Convert to Invoice button only appears when the quote status is Accepted and no invoice has been created from this quote yet.',
            ],
        ],

        'invoices' => [
            'title'     => 'Invoices & Payments',
            'nav_label' => 'Invoices & Payments',
            'intro'     => 'The Invoices module (ERP) allows you to issue invoices, record payments, and track outstanding balances. Overdue detection runs automatically every day.',

            'issuing' => [
                'heading' => 'Issuing an Invoice',
                'steps'   => [
                    'In the left sidebar under ERP, click Invoices.',
                    'Click New Invoice (or convert an accepted quote).',
                    'Link the invoice to a company and optionally a contact.',
                    'Add line items and set quantities and prices.',
                    'Set the issue date and due date.',
                    'Click Create to save the invoice in Draft status.',
                    'Click Mark as Issued to send it to the customer.',
                ],
                'tip' => 'Invoice numbers are generated automatically in the format INV-YYYYMM-NNNN and cannot be edited manually.',
            ],

            'payments' => [
                'heading' => 'Recording Payments',
                'steps'   => [
                    'Open the invoice record.',
                    'Click the Record Payment button.',
                    'Enter the payment amount, date, and method (Bank Transfer, Card, Cash, or Other).',
                    'Add a reference note if needed.',
                    'Click Save.',
                    'The invoice status updates automatically: Partial if part-paid, Paid when fully settled.',
                ],
            ],

            'status' => [
                'heading' => 'Invoice Statuses',
                'body'    => 'Invoices move through the following statuses:',
                'items'   => [
                    'Draft — created but not yet issued.',
                    'Issued — sent to the customer, awaiting payment.',
                    'Partial — one or more payments recorded but balance remains outstanding.',
                    'Paid — fully settled.',
                    'Overdue — the due date has passed and payment has not been received.',
                    'Void — cancelled and no longer active.',
                ],
            ],

            'overdue' => [
                'heading' => 'Automatic Overdue Detection',
                'body'    => 'A scheduled command runs every day at 01:00 (server time) and automatically marks issued or partial invoices as Overdue when their due date has passed. No manual action is required. You can view overdue invoices by filtering the Invoices list by the Overdue status.',
            ],

            'pdf' => [
                'heading' => 'Exporting to PDF',
                'steps'   => [
                    'Open the invoice record.',
                    'Click the Export PDF button.',
                    'A PDF is generated and downloaded immediately.',
                ],
            ],
        ],

        'projects' => [
            'title'     => 'Projects',
            'nav_label' => 'Projects',
            'intro'     => 'The Projects module (ERP) lets you track deliverables and work after a deal is won. Link projects to companies and opportunities, manage milestones, assign tasks, and monitor progress on a Kanban board.',

            'creating' => [
                'heading' => 'Creating a Project',
                'steps'   => [
                    'In the left sidebar under ERP, click Projects.',
                    'Click New Project.',
                    'Enter the project name and an optional description.',
                    'Link it to a company and an opportunity if applicable.',
                    'Set the start and end dates.',
                    'Choose the initial status: Planning, Active, On Hold, Completed, or Cancelled.',
                    'Click Create.',
                ],
            ],

            'milestones' => [
                'heading' => 'Managing Milestones',
                'body'    => 'Milestones mark significant checkpoints in a project. They appear in the Milestones tab of the project view page.',
                'steps'   => [
                    'Open the project record.',
                    'Click the Milestones tab.',
                    'Click Add Milestone.',
                    'Enter a name and optional due date.',
                    'Click Save.',
                    'Mark a milestone as complete by toggling the Completed checkbox.',
                ],
            ],

            'tasks' => [
                'heading' => 'Linking Tasks to a Project',
                'body'    => 'Tasks can be assigned to a project to track individual work items. You can add tasks from within the project record or link an existing task to a project from the task edit form.',
                'steps'   => [
                    'Open the project record.',
                    'Click the Tasks tab.',
                    'Click Add Task to create a new task linked to this project.',
                    'Alternatively, open an existing task and set the Project field to link it.',
                ],
            ],

            'kanban' => [
                'heading' => 'Projects Kanban Board',
                'body'    => 'The Projects Kanban board groups projects by their status column.',
                'steps'   => [
                    'In the Projects section, click the Board tab.',
                    'Projects are grouped into columns: Planning, Active, On Hold, Completed, Cancelled.',
                    'Drag a project card to a different column to change its status.',
                    'Click a card to open the full project record.',
                ],
            ],
        ],

        'erp-feature-flag' => [
            'title'     => 'ERP Feature Flag',
            'nav_label' => 'ERP Feature Flag',
            'intro'     => 'The ERP module (Products, Quotes, Invoices, Projects) is disabled by default for each workspace. The workspace owner can enable or disable it at any time from the Team settings page.',

            'enabling' => [
                'heading' => 'Enabling or Disabling ERP',
                'body'    => 'Only the team owner (the person who created the workspace) can toggle the ERP feature flag.',
                'steps'   => [
                    'Log in as the workspace owner.',
                    'Click your workspace name in the top navigation.',
                    'Select Team Settings from the dropdown.',
                    'Scroll to the ERP Settings section at the bottom of the page.',
                    'Toggle the Enable ERP Features switch on or off.',
                    'Click Save.',
                    'The ERP navigation items appear or disappear immediately on the next page load.',
                ],
                'note' => 'The ERP Settings section is only visible to the team owner. Other team members will not see this section even if they have admin roles.',
            ],

            'visibility' => [
                'heading' => 'What Changes When ERP Is Enabled',
                'body'    => 'When ERP is enabled for a workspace, the following changes take effect:',
                'items'   => [
                    'An ERP section appears in the left sidebar with Products, Quotes, Invoices, and Projects.',
                    'The Convert to Invoice action becomes available on accepted quotes.',
                    'The Project field becomes available on task records.',
                    'Quotes and Invoices relation tabs appear on Company and People view pages.',
                ],
            ],
        ],

        'landing-page-config' => [
            'title'     => 'Landing Page Configuration',
            'nav_label' => 'Landing Page Config',
            'intro'     => 'You can customise the landing page of your Relaticle instance — including the logo, hero banner image, and all visible text — without modifying any code. Changes are made via environment variables and language files.',

            'env_vars' => [
                'heading' => 'Environment Variables',
                'body'    => 'Two environment variables control visual assets on the landing page:',
                'items'   => [
                    'LANDING_HERO_BANNER_IMAGE — A public URL or path to an image displayed above the hero headline. Leave blank to show no banner.',
                    'LANDING_LOGO_CUSTOM_PATH — A public URL or path to a custom logo image. When set, this replaces the default Relaticle logo in the header, footer, and mobile menu.',
                ],
                'steps'   => [
                    'Open your .env file on the server.',
                    'Add or update the variables: LANDING_HERO_BANNER_IMAGE=https://example.com/banner.png',
                    'Run php artisan config:clear to apply the changes.',
                    'Reload the landing page to verify the new assets appear.',
                ],
                'tip' => 'Use an absolute HTTPS URL for the image path to ensure it loads correctly across all environments.',
            ],

            'copy' => [
                'heading' => 'Editing Landing Page Text',
                'body'    => 'All landing page text is stored in language files. To customise the copy:',
                'steps'   => [
                    'Open lang/en/landing.php for English text.',
                    'Open lang/bg/landing.php for Bulgarian text.',
                    'Edit the string values for the keys you want to change — for example, hero.headline, features.heading, or footer.description.',
                    'Save the files.',
                    'Run php artisan config:clear if any values are cached.',
                    'Reload the landing page to see your changes.',
                ],
                'note' => 'Do not remove any keys from the language files — missing keys will cause the page to display blank text. Only change the values (right-hand side of each key-value pair).',
            ],

            'features' => [
                'heading' => 'Customising Feature Tiles',
                'body'    => 'The features section on the landing page is driven by the features.items array in the language file. Each item has a title, description, and an SVG icon path string. You can edit the title and description of any feature tile by modifying the corresponding entry in lang/en/landing.php.',
                'note' => 'The SVG icon strings contain raw SVG path data. Only edit them if you are familiar with SVG markup — an invalid path string will break the icon display.',
            ],
        ],
    ],
];
