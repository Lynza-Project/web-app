<?php

use App\Livewire\Tickets\Create;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('it validates required fields', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('subject', '')
        ->set('description', '')
        ->call('createTicket')
        ->assertHasErrors(['subject', 'description']);
});

test('it validates status field', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('subject', 'Test Subject')
        ->set('description', 'Test Description')
        ->set('status', 'invalid-status')
        ->call('createTicket')
        ->assertHasErrors(['status']);
});

test('it can create a ticket', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('subject', 'Test Ticket')
        ->set('description', 'This is a test ticket description')
        ->set('status', 'open')
        ->call('createTicket')
        ->assertDispatched('ticketCreated')
        ->assertRedirect(route('tickets.show', Ticket::latest()->first()));

    $this->assertDatabaseHas('tickets', [
        'subject' => 'Test Ticket',
        'description' => 'This is a test ticket description',
        'status' => 'open',
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);
});

test('it resets form after successful creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    // We need to mock the redirect to test the form reset
    $component = Livewire::test(Create::class)
        ->set('subject', 'Test Ticket')
        ->set('description', 'This is a test ticket description')
        ->set('status', 'closed');

    // Call the method but intercept the redirect
    $component->call('createTicket');

    // Check that the form fields are reset
    $component->assertSet('subject', '')
              ->assertSet('description', '')
              ->assertSet('status', 'open');
});
