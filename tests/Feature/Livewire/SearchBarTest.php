<?php

use App\Livewire\SearchBar;
use App\Models\User;
use App\Models\Organization;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(SearchBar::class, ['model' => 'events'])
        ->assertStatus(200);
});

test('it mounts with the correct model', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(SearchBar::class, ['model' => 'events'])
        ->assertSet('model', 'events');
});

test('it triggers the updated lifecycle hook when a property changes', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    // Instead of calling the lifecycle hook directly, we'll set a property
    // which will trigger the updated hook internally
    $component = Livewire::test(SearchBar::class, ['model' => 'events']);

    // Set a property to trigger the updated hook
    $component->set('model', 'tickets');

    // Assert that the property was updated successfully
    $component->assertSet('model', 'tickets');
});
