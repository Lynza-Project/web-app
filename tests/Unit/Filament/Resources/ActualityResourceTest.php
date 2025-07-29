<?php

use App\Filament\Resources\ActualityResource;
use App\Models\Actuality;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

test('actuality resource uses correct model', function () {
    expect(ActualityResource::getModel())->toBe(Actuality::class);
});

test('actuality resource has correct slug', function () {
    expect(ActualityResource::getSlug())->toBe('actualities');
});

test('actuality resource has correct navigation icon', function () {
    expect(ActualityResource::getNavigationIcon())->toBe('heroicon-o-megaphone');
});

test('actuality resource has correct navigation label', function () {
    expect(ActualityResource::getNavigationLabel())->toBe('Actualités');
});

test('actuality resource has correct label', function () {
    expect(ActualityResource::getModelLabel())->toBe('Gestion des actualités');
});




test('actuality resource eloquent query includes soft deleted models', function () {
    $query = ActualityResource::getEloquentQuery();

    $scopes = collect($query->removedScopes());
    expect($scopes->contains(SoftDeletingScope::class))->toBeTrue();
});

test('actuality resource has correct global search attributes', function () {
    $attributes = ActualityResource::getGloballySearchableAttributes();

    expect($attributes)->toBeArray()
        ->toContain('title')
        ->toContain('organization.name')
        ->toContain('user.email');
});

