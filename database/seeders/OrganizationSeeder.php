<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {

        $organizations = [
            'Lycée Jean Moulin',
            'Université Paris-Sorbonne',
            'Collège Pierre Curie',
            'École Primaire Victor Hugo',
            'Académie de Musique Chopin',
            'Institut Supérieur des Beaux-Arts',
            'Conservatoire National de Danse',
            'Club Sportif Olympique',
            'Association des Jeunes Entrepreneurs',
            'École de Programmation DevMaster',
            'Centre de Recherche Scientifique',
            'Fédération Nationale des Artisans'
        ];

        Organization::create([
            'name' => 'Super Org',
            'type' => 'organization',
            'logo' => null,
        ]);

        foreach ($organizations as $orgName) {

            Organization::create([
                'name' => $orgName,
                'type' => 'School',
                'logo' => null,
            ]);
        }
    }
}
