<?php

namespace Database\Factories;

use App\Models\LostAndFoundCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LostAndFoundCategoryFactory extends Factory
{
    protected $model = LostAndFoundCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
