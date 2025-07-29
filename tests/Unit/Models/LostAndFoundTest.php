<?php

namespace Tests\Unit\Models;

use App\Models\LostAndFound;
use App\Models\LostAndFoundCategory;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LostAndFoundTest extends TestCase
{
    use RefreshDatabase;

    public function test_lost_and_found_can_be_created()
    {
        $organization = Organization::factory()->create();
        $category = LostAndFoundCategory::factory()->create();

        $lostAndFound = LostAndFound::create([
            'organization_id' => $organization->id,
            'title' => 'Lost Laptop',
            'description' => 'MacBook Pro lost in the cafeteria',
            'lost_and_found_category_id' => $category->id,
            'date_lost' => '2023-01-15',
            'location' => 'Cafeteria',
            'status' => 'lost',
        ]);

        $this->assertInstanceOf(LostAndFound::class, $lostAndFound);
        $this->assertEquals('Lost Laptop', $lostAndFound->title);
        $this->assertEquals('MacBook Pro lost in the cafeteria', $lostAndFound->description);
        $this->assertEquals('Cafeteria', $lostAndFound->location);
        $this->assertEquals('lost', $lostAndFound->status);
    }

    public function test_lost_and_found_belongs_to_organization()
    {
        $organization = Organization::factory()->create();
        $lostAndFound = LostAndFound::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(Organization::class, $lostAndFound->organization);
        $this->assertEquals($organization->id, $lostAndFound->organization->id);
    }

    public function test_lost_and_found_belongs_to_category()
    {
        $category = LostAndFoundCategory::factory()->create();
        $lostAndFound = LostAndFound::factory()->create([
            'lost_and_found_category_id' => $category->id,
        ]);

        $this->assertInstanceOf(LostAndFoundCategory::class, $lostAndFound->lostAndFoundCategory);
        $this->assertEquals($category->id, $lostAndFound->lostAndFoundCategory->id);
    }

    public function test_date_lost_is_cast_to_date()
    {
        $lostAndFound = LostAndFound::factory()->create([
            'date_lost' => '2023-01-15',
        ]);

        $this->assertIsObject($lostAndFound->date_lost);
        $this->assertEquals('2023-01-15', $lostAndFound->date_lost->format('Y-m-d'));
    }
}
