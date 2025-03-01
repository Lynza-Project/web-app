<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // Super Admin unique
        User::create([
            'email' => 'admin@admin.com',
            'password' => $password,
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'organization_id' => 1,
            'role' => 'super-admin',
            'profile_picture' => 'https://randomuser.me/api/portraits/men/1.jpg',
        ]);

        // Liste des organisations et utilisateurs dédiés
        $organizations = Organization::all();

        foreach ($organizations as $org) {
            User::create([
                'email' => 'admin@' . strtolower(str_replace(' ', '', $org->name)) . '.com',
                'password' => $password,
                'first_name' => 'Admin',
                'last_name' => $org->name,
                'organization_id' => $org->id,
                'role' => 'admin',
                'profile_picture' => 'https://randomuser.me/api/portraits/men/1.jpg',
            ]);

            User::create([
                'email' => 'user@' . strtolower(str_replace(' ', '', $org->name)) . '.com',
                'password' => $password,
                'first_name' => 'User',
                'last_name' => $org->name,
                'organization_id' => $org->id,
                'role' => 'user',
                'profile_picture' => 'https://randomuser.me/api/portraits/men/1.jpg',
            ]);

            for ($i = 0; $i < 25; $i++) {
                User::create([
                    'email' => 'user' . $i . '@' . strtolower(str_replace(' ', '', $org->name)) . '.com',
                    'password' => $password,
                    'first_name' => 'User' . $i,
                    'last_name' => $org->name,
                    'organization_id' => $org->id,
                    'role' => 'user',
                    'profile_picture' => 'https://randomuser.me/api/portraits/men/' . $i . '.jpg',
                ]);
            }
        }
    }
}
