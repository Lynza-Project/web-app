<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Theme;
use App\Models\Organization;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Organization fields
    public string $organization_name = '';
    public string $organization_type = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_type' => ['required', 'string', 'max:255'],
        ]);

        // Create organization first
        $organization = Organization::create([
            'name' => $validated['organization_name'],
            'type' => $validated['organization_type'],
        ]);

        // Create a default blue theme for the organization
        $theme = Theme::create([
            'organization_id' => $organization->id,
            'title' => 'Thème Bleu',
            'primary' => 'blue-500',
            'font' => 'Arial',
            'background_color' => 'white',
            'button_color' => 'blue-500',
        ]);

        // Create user with organization_id, theme_id and set as admin
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'organization_id' => $organization->id,
            'theme_id' => $theme->id,
            'role' => 'admin',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
