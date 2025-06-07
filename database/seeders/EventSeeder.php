<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class EventSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $organizations = Organization::all();
        $users = User::all();

        foreach ($organizations as $organization) {
            $organizationUsers = $users->where('organization_id', $organization->id);

            if ($organizationUsers->isEmpty()) {
                $organizationUsers = $users;
            }

            for ($i = 1; $i <= 10; $i++) {
                $eventType = random_int(1, 4);
                $startDate = now()->addDays(random_int(1, 30));

                switch ($eventType) {
                    case 1: // Single day event with time
                        Event::create([
                            'organization_id' => $organization->id,
                            'user_id' => $organizationUsers->random()->id,
                            'title' => "Événement " . $i . " - " . $organization->name,
                            'description' => "Description de l'événement " . $i . " (journée unique avec horaires)",
                            'start_date' => $startDate,
                            'end_date' => null,
                            'start_time' => sprintf('%02d:00', random_int(8, 18)),
                            'end_time' => sprintf('%02d:00', random_int(19, 22)),
                            'location' => "Lieu " . random_int(1, 10),
                        ]);
                        break;

                    case 2: // Multi-day event with time
                        Event::create([
                            'organization_id' => $organization->id,
                            'user_id' => $organizationUsers->random()->id,
                            'title' => "Événement " . $i . " - " . $organization->name,
                            'description' => "Description de l'événement " . $i . " (plusieurs jours avec horaires)",
                            'start_date' => $startDate,
                            'end_date' => (clone $startDate)->addDays(random_int(1, 5)),
                            'start_time' => sprintf('%02d:00', random_int(8, 12)),
                            'end_time' => sprintf('%02d:00', random_int(13, 18)),
                            'location' => "Lieu " . random_int(1, 10),
                        ]);
                        break;

                    case 3: // Single day event without time
                        Event::create([
                            'organization_id' => $organization->id,
                            'user_id' => $organizationUsers->random()->id,
                            'title' => "Événement " . $i . " - " . $organization->name,
                            'description' => "Description de l'événement " . $i . " (journée unique sans horaires)",
                            'start_date' => $startDate,
                            'end_date' => null,
                            'start_time' => null,
                            'end_time' => null,
                            'location' => "Lieu " . random_int(1, 10),
                        ]);
                        break;

                    case 4: // Multi-day event without time
                        Event::create([
                            'organization_id' => $organization->id,
                            'user_id' => $organizationUsers->random()->id,
                            'title' => "Événement " . $i . " - " . $organization->name,
                            'description' => "Description de l'événement " . $i . " (plusieurs jours sans horaires)",
                            'start_date' => $startDate,
                            'end_date' => (clone $startDate)->addDays(random_int(1, 5)),
                            'start_time' => null,
                            'end_time' => null,
                            'location' => "Lieu " . random_int(1, 10),
                        ]);
                        break;
                }
            }
        }
    }
}
