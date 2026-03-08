<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class DocumentationController
{
    /** @var array<int, array{slug: string, section: string}> */
    private const array PAGES = [
        ['slug' => 'getting-started',    'section' => 'getting_started'],
        ['slug' => 'companies',          'section' => 'crm'],
        ['slug' => 'people',             'section' => 'crm'],
        ['slug' => 'opportunities',      'section' => 'crm'],
        ['slug' => 'tasks',              'section' => 'crm'],
        ['slug' => 'notes',              'section' => 'crm'],
        ['slug' => 'activity-timeline',  'section' => 'crm'],
        ['slug' => 'email-integration',  'section' => 'crm'],
        ['slug' => 'custom-reports',     'section' => 'crm'],
        ['slug' => 'products',           'section' => 'erp'],
        ['slug' => 'quotes',             'section' => 'erp'],
        ['slug' => 'invoices',           'section' => 'erp'],
        ['slug' => 'projects',           'section' => 'erp'],
        ['slug' => 'erp-feature-flag',   'section' => 'configuration'],
        ['slug' => 'landing-page-config', 'section' => 'configuration'],
    ];

    public function index(): RedirectResponse
    {
        return redirect()->route('documentation.show', ['page' => 'getting-started']);
    }

    public function show(string $page): View
    {
        $allowed = array_column(self::PAGES, 'slug');

        if (! in_array($page, $allowed, true)) {
            throw new NotFoundHttpException();
        }

        return view('documentation.show', [
            'page'     => $page,
            'sections' => self::PAGES,
        ]);
    }
}
