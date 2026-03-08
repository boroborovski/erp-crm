<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Company;
use App\Models\Opportunity;
use App\Models\People;

enum ReportEntity: string
{
    case Company = 'company';
    case People = 'people';
    case Opportunity = 'opportunity';

    public function getLabel(): string
    {
        return match ($this) {
            self::Company => __('resources.models.company.singular'),
            self::People => __('resources.models.people.singular'),
            self::Opportunity => __('resources.models.opportunity.singular'),
        };
    }

    public function getModelClass(): string
    {
        return match ($this) {
            self::Company => Company::class,
            self::People => People::class,
            self::Opportunity => Opportunity::class,
        };
    }

    /**
     * @return array<string, string>
     */
    public function getAvailableColumns(): array
    {
        return match ($this) {
            self::Company => [
                'name' => __('reports.columns.name'),
                'phone' => __('reports.columns.phone'),
                'address' => __('reports.columns.address'),
                'country' => __('reports.columns.country'),
                'created_at' => __('reports.columns.created_at'),
            ],
            self::People => [
                'name' => __('reports.columns.name'),
                'company_name' => __('reports.columns.company'),
                'created_at' => __('reports.columns.created_at'),
            ],
            self::Opportunity => [
                'name' => __('reports.columns.name'),
                'company_name' => __('reports.columns.company'),
                'contact_name' => __('reports.columns.contact'),
                'created_at' => __('reports.columns.created_at'),
            ],
        };
    }

    /**
     * @return array<string, string>
     */
    public function getFilterableFields(): array
    {
        return match ($this) {
            self::Company => [
                'name' => __('reports.columns.name'),
                'phone' => __('reports.columns.phone'),
                'address' => __('reports.columns.address'),
                'country' => __('reports.columns.country'),
                'created_at' => __('reports.columns.created_at'),
            ],
            self::People => [
                'name' => __('reports.columns.name'),
                'created_at' => __('reports.columns.created_at'),
            ],
            self::Opportunity => [
                'name' => __('reports.columns.name'),
                'created_at' => __('reports.columns.created_at'),
            ],
        };
    }

    /**
     * @return array<string, string>
     */
    public static function selectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $entity): array => [$entity->value => $entity->getLabel()])
            ->all();
    }

    /**
     * @return array<string, string>
     */
    public static function filterOperators(): array
    {
        return [
            'equals' => __('reports.operators.equals'),
            'not_equals' => __('reports.operators.not_equals'),
            'contains' => __('reports.operators.contains'),
            'starts_with' => __('reports.operators.starts_with'),
            'greater_than' => __('reports.operators.greater_than'),
            'less_than' => __('reports.operators.less_than'),
            'is_empty' => __('reports.operators.is_empty'),
            'is_not_empty' => __('reports.operators.is_not_empty'),
        ];
    }
}
