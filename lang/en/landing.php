<?php

declare(strict_types=1);

return [
    'meta' => [
        'title'          => 'The Complete CRM & ERP Platform',
        'description'    => 'A modern CRM & ERP platform designed for businesses. Manage customers, leads, opportunities, quotes, invoices, and projects with ease.',
        'og_title'       => 'CRM & ERP Platform',
        'og_description' => 'The complete CRM & ERP platform. Powerful, flexible, and built for modern businesses.',
    ],

    'nav' => [
        'features'        => 'Features',
        'documentation'   => 'Documentation',
        'about'           => 'About',
        'sign_in'         => 'Sign In',
        'login'           => 'Login',
        'theme'           => 'Theme',
        'quick_links'     => 'Quick Links',
        'support_legal'   => 'Support & Legal',
        'home'            => 'Home',
        'privacy_policy'  => 'Privacy Policy',
        'terms_of_service' => 'Terms of Service',
        'contact_us'      => 'Contact Us',
        'language'        => 'Language',
    ],

    'hero' => [
        'headline'           => 'The Complete',
        'headline_highlight' => 'CRM & ERP Platform',
        'subheadline'        => 'Manage your customer relationships, sales pipeline, quotes, invoices, and projects — all in one modern platform built for teams that mean business.',
        'cta_primary'        => 'Login',
        'preview_alt'        => 'CRM & ERP Dashboard',
        'stats'              => [
            'modern_stack' => [
                'title'       => 'Modern Stack',
                'description' => 'PHP 8.4, Laravel 12',
            ],
            'secure' => [
                'title'       => 'Secure',
                'description' => 'Enterprise-grade security',
            ],
            'scalable' => [
                'title'       => 'Scalable',
                'description' => 'Grows with your business',
            ],
            'reliable' => [
                'title'       => 'Reliable',
                'description' => 'Built for uptime',
            ],
        ],
    ],

    'features' => [
        'badge'          => 'Features',
        'heading'        => 'Everything you need — CRM and ERP in one place',
        'subheading'     => 'From first contact to final invoice, manage every stage of your business in a single, cohesive platform.',
        'cta_heading'    => 'Ready to take control of your business?',
        'cta_subheading' => 'Log in and start managing your CRM & ERP today.',
        'cta_button'     => 'Login',
        'items'          => [
            [
                'title'       => 'Companies & Contacts',
                'description' => 'Maintain detailed company and contact profiles with full interaction histories, custom fields, and activity timelines to keep every relationship in context.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
            ],
            [
                'title'       => 'Sales Pipeline',
                'description' => 'Visualize and manage your sales pipeline with a Kanban board, custom stages, lifecycle tracking, and detailed outcome analysis to drive deals forward.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />',
            ],
            [
                'title'       => 'Activity Timeline',
                'description' => 'Every interaction is automatically recorded — notes, tasks, emails, and updates — displayed in a chronological feed on each record\'s view page.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
            ],
            [
                'title'       => 'Email Integration',
                'description' => 'Send and receive emails directly from a contact or company record. Full thread view, IMAP polling, and outbound via your configured mailer — all inside the platform.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />',
            ],
            [
                'title'       => 'Custom Reports',
                'description' => 'Build tabular reports from your CRM data with filter conditions and column selection. Export results to CSV instantly — no coding required.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            ],
            [
                'title'       => 'Products & Catalog',
                'description' => 'Maintain a central catalog of products and services with categories, pricing, units, and custom fields. The foundation for accurate quotes and invoices.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
            ],
            [
                'title'       => 'Quotes & Proposals',
                'description' => 'Create professional quotes from your product catalog or as free-form line items. Export to PDF, send by email, and convert accepted quotes to invoices in one click.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            ],
            [
                'title'       => 'Invoices & Payments',
                'description' => 'Issue invoices manually or from accepted quotes, record full and partial payments, and track outstanding balances. Overdue detection runs automatically each day.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />',
            ],
            [
                'title'       => 'Project Management',
                'description' => 'Track deliverables after a deal is won. Link projects to companies and opportunities, manage milestones, assign tasks, and monitor progress on a Kanban board.',
                'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />',
            ],
        ],
    ],

    'about' => [
        'heading'     => 'About Us',
        'subheading'  => 'Our Mission',
        'description' => 'A modern CRM & ERP platform designed to help businesses build better relationships with their customers and run their operations efficiently. Our mission is to provide powerful, intuitive tools that grow with your business.',
        'address'     => '',
        'email'       => '',
        'phone'       => '',
    ],

    'start_building' => [
        'heading'        => 'Ready to get started?',
        'subheading'     => 'Powerful. Flexible. Built for your business.',
        'cta_button'     => 'Login',
        'no_credit_card' => 'No credit card',
        'deploy_time'    => 'Deploy in 5 minutes',
    ],

    'footer' => [
        'description' => 'The complete CRM & ERP platform — manage customer relationships, sales pipeline, quotes, invoices, and projects in one modern, intuitive system.',
        'copyright'   => '© :year CRM & ERP Platform. All rights reserved.',
    ],
];
