<?php

use App\Livewire\Users\Import;
use App\Models\User;
use App\Models\Organization;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Import::class)
        ->assertStatus(200);
});

test('it can download template', function () {
    Excel::fake();

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Import::class)
        ->call('downloadTemplate');

    Excel::assertDownloaded('users_import_template.xlsx');
});
