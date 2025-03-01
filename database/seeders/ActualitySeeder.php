<?php

namespace Database\Seeders;

use App\Models\Actuality;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActualitySeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::all();
        $users = User::all();

        foreach ($organizations as $organization) {
            for ($i = 1; $i <= 10; $i++) {
                Actuality::create([
                    'organization_id' => $organization->id,
                    'user_id' => $users->random()->id,
                    'title' => 'Actualités ' . $i . ' - ' . $organization->name,
                    'content' => 'Description de l\'actualité ' . $i . ' de l\'établissement ' . $organization->name,
                ]);
            }
        }
    }
}
