<div class="flex flex-col gap-8 max-w-6xl mx-auto w-full px-4 py-8">
    <x-auth-header title="Créer un compte" description="Inscrivez-vous et votre organisation en une étape" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-10">
        <!-- Two-column layout container for desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Personal Information Section -->
            <div class="bg-white p-10 rounded-xl shadow-md border border-slate-200 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden h-full">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                <h2 class="text-xl font-semibold text-slate-800 mb-6 flex items-center">
                    <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Informations personnelles
                </h2>
                <div class="flex flex-col gap-6">
                    <!-- First Name and Last Name (side by side on larger screens) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <flux:input
                            wire:model="first_name"
                            id="first_name"
                            :label="__('Prénom')"
                            type="text"
                            name="first_name"
                            required
                            autofocus
                            autocomplete="given-name"
                            placeholder="Prénom"
                            class="text-base"
                            input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                        />

                        <!-- Last Name -->
                        <flux:input
                            wire:model="last_name"
                            id="last_name"
                            :label="__('Nom')"
                            type="text"
                            name="last_name"
                            required
                            autocomplete="family-name"
                            placeholder="Nom"
                            class="text-base"
                            input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                        />
                    </div>

                    <!-- Email Address -->
                    <flux:input
                        wire:model="email"
                        id="email"
                        :label="__('Adresse e-mail')"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="text-base"
                        input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                    />

                    <!-- Password and Confirm Password (side by side on larger screens) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <flux:input
                            wire:model="password"
                            id="password"
                            :label="__('Mot de passe')"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Mot de passe"
                            class="text-base"
                            input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                        />

                        <!-- Confirm Password -->
                        <flux:input
                            wire:model="password_confirmation"
                            id="password_confirmation"
                            :label="__('Confirmer le mot de passe')"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirmer le mot de passe"
                            class="text-base"
                            input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                        />
                    </div>
                </div>
            </div>

            <!-- Organization Information Section -->
            <div class="bg-white p-10 rounded-xl shadow-md border border-slate-200 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden h-full">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-indigo-500"></div>
                <h2 class="text-xl font-semibold text-slate-800 mb-6 flex items-center">
                    <span class="bg-purple-100 text-purple-600 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2a1 1 0 00-1-1H7a1 1 0 00-1 1v2a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Informations de l'organisation
                </h2>
                <div class="flex flex-col gap-6">
                    <!-- Organization Name -->
                    <flux:input
                        wire:model="organization_name"
                        id="organization_name"
                        :label="__('Nom de l\'organisation')"
                        type="text"
                        name="organization_name"
                        required
                        autocomplete="organization"
                        placeholder="Nom de votre organisation"
                        class="text-base"
                        input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all duration-200"
                    />

                    <!-- Organization Type -->
                    <flux:input
                        wire:model="organization_type"
                        id="organization_type"
                        :label="__('Type d\'organisation')"
                        type="text"
                        name="organization_type"
                        required
                        placeholder="ex: Éducation, Entreprise, Association"
                        class="text-base"
                        input-class="py-3 px-4 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all duration-200"
                    />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <flux:button
                type="submit"
                variant="primary"
                class="max-w-md mx-auto py-2 text-base font-medium rounded-lg shadow-sm hover:shadow transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700"
            >
                {{ __('Créer compte & organisation') }}
            </flux:button>
        </div>
    </form>

    <div class="mt-8 text-center">
        <p class="text-base text-slate-600 mb-2">Vous avez déjà un compte?</p>
        <flux:link
            :href="route('login')"
            wire:navigate
            class="text-indigo-600 hover:text-indigo-800 font-medium text-lg inline-flex items-center transition-colors duration-200"
        >
            Connexion
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </flux:link>
    </div>
</div>
