<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user who has already verified their email is redirected to the dashboard.
     * This covers line 18 in VerifyEmailController.
     */
    public function test_already_verified_user_is_redirected_to_dashboard()
    {
        // Arrange
        Event::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Act
        $response = $this->actingAs($user)->get($verificationUrl);

        // Assert
        Event::assertNotDispatched(Verified::class);
        $response->assertRedirect(route('dashboard') . '?verified=1');
    }
}
