<?php

use App\Filament\Resources\ActualityResource;
use App\Filament\Resources\ActualityResource\Pages\EditActuality;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

test('edit actuality page uses correct resource', function () {
    $reflection = new ReflectionClass(EditActuality::class);
    $property = $reflection->getProperty('resource');
    $property->setAccessible(true);

    expect($property->getValue())->toBe(ActualityResource::class);
});

test('edit actuality page has correct title', function () {
    $reflection = new ReflectionClass(EditActuality::class);
    $property = $reflection->getProperty('title');
    $property->setAccessible(true);

    expect($property->getValue())->toBe('Formulaire de modification');
});

