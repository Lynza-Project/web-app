<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'primary' => fake()->colorName(),
            'font' => fake()->word(),
            'background_color' => fake()->colorName(),
            'button_color' => fake()->colorName(),
            'logo_path' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'organization_id' => Organization::factory(),
        ];
    }
}
