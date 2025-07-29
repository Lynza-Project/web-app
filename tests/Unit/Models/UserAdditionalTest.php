<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAdditionalTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_filament_name_returns_first_name()
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John', $user->getFilamentName());
    }

    public function test_can_access_panel_returns_true_for_super_admin()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super-admin',
        ]);

        $this->actingAs($superAdmin);

        $panel = new Panel();
        $panel->id('superadmin');

        $this->assertTrue($superAdmin->canAccessPanel($panel));
    }

    public function test_can_access_panel_returns_false_for_non_super_admin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $panel = new Panel();
        $panel->id('superadmin');

        $this->assertFalse($admin->canAccessPanel($panel));
    }

    public function test_can_access_panel_returns_false_for_other_panels()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super-admin',
        ]);

        $this->actingAs($superAdmin);

        $panel = new Panel();
        $panel->id('other-panel');

        $this->assertFalse($superAdmin->canAccessPanel($panel));
    }

    public function test_get_profile_picture_url_with_profile_picture()
    {
        Storage::fake('public');

        $picturePath = 'profile-pictures/test.jpg';
        Storage::disk('public')->put($picturePath, 'test content');

        $user = User::factory()->create([
            'profile_picture' => $picturePath,
        ]);

        $expectedUrl = asset('storage/' . $picturePath);
        $this->assertEquals($expectedUrl, $user->getProfilePictureUrlAttribute());
    }

    public function test_get_profile_picture_url_without_profile_picture()
    {
        $user = User::factory()->create([
            'profile_picture' => null,
        ]);

        $expectedUrl = asset('img/user-default.jpg');
        $this->assertEquals($expectedUrl, $user->getProfilePictureUrlAttribute());
    }
}
