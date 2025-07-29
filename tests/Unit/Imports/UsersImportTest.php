<?php

namespace Tests\Unit\Imports;

use App\Imports\UsersImport;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UsersImportTest extends TestCase
{
    /**
     * Test that the collection method correctly processes rows and stores user data.
     */
    public function test_collection_method_processes_rows_correctly()
    {
        // Arrange
        $import = new UsersImport();
        $rows = new Collection([
            [
                'prenom' => 'John',
                'nom' => 'Doe',
                'email' => 'john.doe@example.com',
                'role_user_ou_admin' => 'user'
            ],
            [
                'prenom' => 'Jane',
                'nom' => 'Smith',
                'email' => 'jane.smith@example.com',
                'role_user_ou_admin' => 'admin'
            ]
        ]);

        // Act
        $import->collection($rows);
        $users = $import->getUsers();

        // Assert
        $this->assertCount(2, $users);
        $this->assertEquals([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'role' => 'user'
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'role' => 'admin'
            ]
        ], $users);
    }

    /**
     * Test that the getUsers method returns the expected array of users.
     */
    public function test_get_users_method_returns_expected_array()
    {
        // Arrange
        $import = new UsersImport();
        $rows = new Collection([
            [
                'prenom' => 'John',
                'nom' => 'Doe',
                'email' => 'john.doe@example.com',
                'role_user_ou_admin' => 'user'
            ]
        ]);

        // Act
        $import->collection($rows);
        $users = $import->getUsers();

        // Assert
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertEquals('John', $users[0]['first_name']);
        $this->assertEquals('Doe', $users[0]['last_name']);
        $this->assertEquals('john.doe@example.com', $users[0]['email']);
        $this->assertEquals('user', $users[0]['role']);
    }

    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $import = new UsersImport();

        // Act
        $rules = $import->rules();

        // Assert
        $this->assertEquals([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_user_ou_admin' => 'required|in:user,admin',
        ], $rules);
    }

    /**
     * Test that the customValidationAttributes method returns the expected attribute names.
     */
    public function test_custom_validation_attributes_method_returns_expected_attributes()
    {
        // Arrange
        $import = new UsersImport();

        // Act
        $attributes = $import->customValidationAttributes();

        // Assert
        $this->assertEquals([
            'prenom' => 'Prénom',
            'nom' => 'Nom',
            'email' => 'Email',
            'role_user_ou_admin' => 'Rôle',
        ], $attributes);
    }
}
