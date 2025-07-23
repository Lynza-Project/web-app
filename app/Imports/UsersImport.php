<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @var array
     */
    private array $users = [];

    /**
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows): void
    {
        $this->users = [];

        foreach ($rows as $row) {
            $this->users[] = [
                'first_name' => $row['prenom'],
                'last_name' => $row['nom'],
                'email' => $row['email'],
                'role' => $row['role_user_ou_admin'] === 'admin' ? 'admin' : 'user',
            ];
        }
    }

    /**
     * Get the imported users
     *
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_user_ou_admin' => 'required|in:user,admin',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes(): array
    {
        return [
            'prenom' => 'Prénom',
            'nom' => 'Nom',
            'email' => 'Email',
            'role_user_ou_admin' => 'Rôle',
        ];
    }
}
