<?php

use App\Livewire\Users\ImportPage;
use App\Models\User;
use App\Models\Organization;
use App\Imports\UsersImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Mockery;

test('the component can render for admin users', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    Livewire::test(ImportPage::class)
        ->assertStatus(200);
});

test('the component cannot be accessed by non-admin users', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'user',
    ]);

    $this->actingAs($user);

    // Instead of expecting an exception, we'll check that the component aborts with a 403 status
    Livewire::test(ImportPage::class)
        ->assertForbidden();
});

test('it validates file upload', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    // Test with no file
    Livewire::test(ImportPage::class)
        ->call('uploadFile')
        ->assertHasErrors(['file' => 'required']);

    // Test with invalid file type
    Livewire::test(ImportPage::class)
        ->set('file', UploadedFile::fake()->create('document.pdf', 100))
        ->call('uploadFile')
        ->assertHasErrors(['file' => 'mimes']);
});

test('it can upload a valid file and show preview', function () {
    Storage::fake('local');
    Excel::fake();

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->create('users.xlsx', 100);

    // Mock the UsersImport class behavior
    $mockUsers = [
        [
            'prenom' => 'John',
            'nom' => 'Doe',
            'email' => 'john.doe@example.com',
            'role_user_ou_admin' => 'user',
        ],
        [
            'prenom' => 'Jane',
            'nom' => 'Smith',
            'email' => 'jane.smith@example.com',
            'role_user_ou_admin' => 'user',
        ],
    ];

    // Expected transformed users after import
    $expectedUsers = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ],
        [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'role' => 'user',
        ],
    ];

    // Mock the Excel facade to return a UsersImport instance with mock data
    Excel::shouldReceive('import')
        ->once()
        ->andReturnUsing(function ($import, $uploadedFile) use ($mockUsers) {
            // Call the collection method on the actual import instance
            $import->collection(collect($mockUsers));
            return true;
        });

    // Test the component
    $component = Livewire::test(ImportPage::class)
        ->set('file', $file)
        ->call('uploadFile');

    $component->assertSet('users', $expectedUsers);
});

test('it shows error when no users found in file', function () {
    Storage::fake('local');
    Excel::fake();

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->create('empty.xlsx', 100);

    Excel::shouldReceive('import')
        ->once()
        ->andReturnUsing(function ($import, $uploadedFile) {
            $import->collection(collect([]));
            return true;
        });

    $component = Livewire::test(ImportPage::class)
        ->set('file', $file)
        ->call('uploadFile')
        ->assertSet('showPreview', false)
        ->assertSet('errorMessage', 'Aucun utilisateur trouvé dans le fichier.');
});

test('it handles exceptions during file upload', function () {
    Storage::fake('local');
    Excel::fake();

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->create('users.xlsx', 100);

    Excel::shouldReceive('import')
        ->once()
        ->andThrow(new \Exception('Test exception'));

    $component = Livewire::test(ImportPage::class)
        ->set('file', $file)
        ->call('uploadFile')
        ->assertSet('showPreview', false)
        ->assertSet('errorMessage', 'Une erreur est survenue lors de l\'importation du fichier: Test exception');
});

test('it can remove a user from preview', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $mockUsers = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ],
        [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'role' => 'user',
        ],
    ];

    Livewire::test(ImportPage::class)
        ->set('users', $mockUsers)
        ->call('removeUser', 0)
        ->assertSet('users', [
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'role' => 'user',
            ],
        ]);
});

test('it can remove the last user from preview', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $mockUsers = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ],
    ];

    Livewire::test(ImportPage::class)
        ->set('users', $mockUsers)
        ->call('removeUser', 0)
        ->assertSet('users', []);
});

test('it handles invalid index when removing user', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $mockUsers = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ],
    ];

    // Test with an index that doesn't exist
    Livewire::test(ImportPage::class)
        ->set('users', $mockUsers)
        ->call('removeUser', 999)
        ->assertSet('users', $mockUsers);
});

test('it can create users from preview', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $mockUsers = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ],
        [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'role' => 'user',
        ],
    ];

    Livewire::test(ImportPage::class)
        ->set('users', $mockUsers)
        ->call('createUsers')
        ->assertRedirect(route('users.index'));

    // Verify users were created
    $this->assertDatabaseHas('users', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'role' => 'user',
        'organization_id' => $organization->id,
    ]);

    $this->assertDatabaseHas('users', [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'role' => 'user',
        'organization_id' => $organization->id,
    ]);

    // Check for flash message
    expect(session()->get('message'))->toContain('Les utilisateurs ont été créés avec succès');
});

test('it handles creating users with empty array', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    // Initial user count
    $initialCount = User::count();

    Livewire::test(ImportPage::class)
        ->set('users', [])
        ->call('createUsers')
        ->assertRedirect(route('users.index'));

    // Verify no new users were created
    expect(User::count())->toBe($initialCount);

    // Check for flash message
    expect(session()->get('message'))->toContain('Les utilisateurs ont été créés avec succès');
});

test('it renders the correct view', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $component = Livewire::test(ImportPage::class);

    // Assert that the component renders the correct view
    $component->assertViewIs('livewire.users.import-page');
});
