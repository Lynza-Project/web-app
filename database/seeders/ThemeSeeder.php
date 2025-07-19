<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Seed the themes table with default themes for each organization
     *
     * @return void
     */
    public function run(): void
    {
        $organizations = Organization::all();

        // We'll use blue-500 as the default primary color for all themes
        $defaultPrimary = 'blue-500';

        // Create a blue theme for each organization
        foreach ($organizations as $org) {
            Theme::create([
                'organization_id' => $org->id,
                'title' => 'Thème ' . $org->name,
                'primary' => $defaultPrimary,
                'font' => 'Arial',
                'background_color' => 'white',
                'button_color' => $defaultPrimary,
            ]);
        }
    }
}
