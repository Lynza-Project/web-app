<?php

namespace App\Filament\Resources\ActualityResource\Pages;

use App\Filament\Resources\ActualityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditActuality extends EditRecord
{
    protected static string $resource = ActualityResource::class;

    protected static ?string $title = 'Formulaire de modification';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
