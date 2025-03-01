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
            'title' => $this->faker->word(),
            'primary' => $this->faker->word(),
            'danger' => $this->faker->word(),
            'gray' => $this->faker->word(),
            'info' => $this->faker->word(),
            'success' => $this->faker->word(),
            'warning' => $this->faker->word(),
            'font' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'organization_id' => Organization::factory(),
        ];
    }
}
