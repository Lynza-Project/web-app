<?php

use App\Exports\UsersImportTemplate;
use Illuminate\Support\Collection;
use Mockery;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

test('users import template returns a collection with sample data', function () {
    $template = new UsersImportTemplate();
    $collection = $template->collection();

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->and($collection->first())
        ->toBe(['Louis', 'Reynard', 'louisreynard@gmail.fr', 'user']);
});

test('users import template returns correct headings', function () {
    $template = new UsersImportTemplate();
    $headings = $template->headings();

    expect($headings)->toBe([
        'Prénom',
        'Nom',
        'Email',
        'Rôle (user ou admin)',
    ]);
});

test('users import template applies bold style to header row', function () {
    $template = new UsersImportTemplate();
    $worksheet = Mockery::mock(Worksheet::class);
    $styles = $template->styles($worksheet);

    expect($styles)
        ->toBeArray()
        ->toHaveKey(1)
        ->and($styles[1])
        ->toBeArray()
        ->toHaveKey('font')
        ->and($styles[1]['font'])
        ->toBeArray()
        ->toHaveKey('bold')
        ->and($styles[1]['font']['bold'])
        ->toBeTrue();
});
