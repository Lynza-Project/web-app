<?php

namespace App\Filament\Resources\ActualityResource\Pages;

use App\Filament\Resources\ActualityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateActuality extends CreateRecord
{
    protected static string $resource = ActualityResource::class;

    protected static ?string $title = 'Formulaire de création';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
