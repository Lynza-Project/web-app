<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(2),
            'start_time' => Carbon::now()->addHours(1)->format('H:i'),
            'end_time' => Carbon::now()->addHours(2)->format('H:i'),
            'location' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
        ];
    }
}
