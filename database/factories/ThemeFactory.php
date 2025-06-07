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
            'primary' => fake()->word(),
            'danger' => fake()->word(),
            'gray' => fake()->word(),
            'info' => fake()->word(),
            'success' => fake()->word(),
            'warning' => fake()->word(),
            'font' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'organization_id' => Organization::factory(),
        ];
    }
}
