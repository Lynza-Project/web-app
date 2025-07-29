<?php

use App\Filament\Resources\ActualityResource;
use App\Filament\Resources\ActualityResource\Pages\ListActualities;
use Filament\Actions\CreateAction;

test('list actualities page uses correct resource', function () {
    $reflection = new ReflectionClass(ListActualities::class);
    $property = $reflection->getProperty('resource');
    $property->setAccessible(true);

    expect($property->getValue())->toBe(ActualityResource::class);
});
