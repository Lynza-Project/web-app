<?php

namespace Tests\Unit\Models;

use App\Models\Theme;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_hex_from_tailwind_color_with_empty_string()
    {
        $result = Theme::getHexFromTailwindColor('');

        $this->assertEquals('', $result);
    }

    public function test_get_hex_from_tailwind_color_with_white()
    {
        $result = Theme::getHexFromTailwindColor('white');

        $this->assertEquals('#ffffff', $result);
    }

    public function test_get_hex_from_tailwind_color_with_valid_color()
    {
        $result = Theme::getHexFromTailwindColor('blue-500');

        $this->assertEquals('#3b82f6', $result);
    }

    public function test_get_hex_from_tailwind_color_with_invalid_color()
    {
        $result = Theme::getHexFromTailwindColor('nonexistent-color');

        $this->assertEquals('#000000', $result);
    }

    public function test_theme_belongs_to_organization()
    {
        $organization = Organization::factory()->create();
        $theme = Theme::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(Organization::class, $theme->organization);
        $this->assertEquals($organization->id, $theme->organization->id);
    }

    public function test_get_tailwind_colors_returns_array()
    {
        $colors = Theme::getTailwindColors();

        $this->assertIsArray($colors);
        $this->assertArrayHasKey('blue', $colors);
        $this->assertArrayHasKey('500', $colors['blue']);
        $this->assertEquals('#3b82f6', $colors['blue']['500']);
    }

    public function test_get_color_options_returns_array_with_white()
    {
        $options = Theme::getColorOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('white', $options);
        $this->assertEquals('White', $options['white']);
    }
}
