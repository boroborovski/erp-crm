<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = Filament::getTenant()->getKey();
        $data['columns'] = $data['columns'] ?? [];
        $data['filters'] = $data['filters'] ?? [];

        return $data;
    }
}
