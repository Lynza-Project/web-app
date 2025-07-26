<?php

use App\Filament\Resources\ActualityResource;
use App\Filament\Resources\ActualityResource\Pages\CreateActuality;

test('create actuality page uses correct resource', function () {
    $reflection = new ReflectionClass(CreateActuality::class);
    $property = $reflection->getProperty('resource');
    $property->setAccessible(true);

    expect($property->getValue())->toBe(ActualityResource::class);
});

test('create actuality page has correct title', function () {
    $reflection = new ReflectionClass(CreateActuality::class);
    $property = $reflection->getProperty('title');
    $property->setAccessible(true);

    expect($property->getValue())->toBe('Formulaire de création');
});
