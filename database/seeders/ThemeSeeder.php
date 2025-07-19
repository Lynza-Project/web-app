<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::all();

        $tailwindColors = [
            'blue-500',
            'red-500',
            'gray-500',
            'sky-400',
            'green-500',
            'yellow-400',
            'indigo-600',
            'purple-500',
            'pink-500',
            'emerald-500',
            'amber-500',
            'teal-500',
        ];

        foreach ($organizations as $org) {
            Theme::create([
                'organization_id' => $org->id,
                'title' => 'Thème ' . $org->name,
                'primary' => $tailwindColors[array_rand($tailwindColors)],
                'danger' => $tailwindColors[array_rand($tailwindColors)],
                'gray' => $tailwindColors[array_rand($tailwindColors)],
                'info' => $tailwindColors[array_rand($tailwindColors)],
                'success' => $tailwindColors[array_rand($tailwindColors)],
                'warning' => $tailwindColors[array_rand($tailwindColors)],
                'font' => 'Arial',
                'background_color' => $tailwindColors[array_rand($tailwindColors)],
                'text_color' => $tailwindColors[array_rand($tailwindColors)],
                'button_color' => $tailwindColors[array_rand($tailwindColors)],
            ]);
        }
    }
}
