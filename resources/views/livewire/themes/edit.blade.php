<div>
    <h3 class="mb-4 text-lg font-medium text-zinc-900 dark:text-white">{{ __('Modifier le thème de votre organisation') }}</h3>
    <form wire:submit="updateTheme">
        <div class="space-y-6">
            <div>
                <flux:label for="title">{{ __('Titre') }}</flux:label>
                <flux:input id="title" wire:model="title" type="text" required />
                @error('title') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label for="primary">{{ __('Couleur primaire') }}</flux:label>
                    <flux:select id="primary" wire:model="primary" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('primary') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="danger">{{ __('Couleur danger') }}</flux:label>
                    <flux:select id="danger" wire:model="danger" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('danger') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label for="gray">{{ __('Couleur grise') }}</flux:label>
                    <flux:select id="gray" wire:model="gray" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('gray') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="info">{{ __('Couleur info') }}</flux:label>
                    <flux:select id="info" wire:model="info" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('info') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label for="success">{{ __('Couleur succès') }}</flux:label>
                    <flux:select id="success" wire:model="success" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('success') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="warning">{{ __('Couleur avertissement') }}</flux:label>
                    <flux:select id="warning" wire:model="warning" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('warning') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <flux:label for="font">{{ __('Police') }}</flux:label>
                <flux:select id="font" wire:model="font" required>
                    <option value="">{{ __('Sélectionner une police') }}</option>
                    <option value="Inter">Inter</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Lato">Lato</option>
                </flux:select>
                @error('font') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div>
                    <flux:label for="background_color">{{ __('Couleur de fond') }}</flux:label>
                    <flux:select id="background_color" wire:model="background_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('background_color') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="text_color">{{ __('Couleur de texte') }}</flux:label>
                    <flux:select id="text_color" wire:model="text_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('text_color') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="button_color">{{ __('Couleur de bouton') }}</flux:label>
                    <flux:select id="button_color" wire:model="button_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @error('button_color') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <flux:label for="newLogo">{{ __('Logo') }}</flux:label>
                <flux:input id="newLogo" wire:model="newLogo" type="file" accept="image/*" />
                @error('newLogo') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror

                <div class="mt-4">
                    @if($newLogo)
                        <div class="mb-2">
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Nouveau logo') }}:</p>
                            <img src="{{ $newLogo->temporaryUrl() }}" alt="New Logo Preview" class="mt-1 h-16 object-contain">
                        </div>
                    @endif

                    @if($logo_path)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Logo actuel') }}:</p>
                            <img src="{{ Storage::disk('s3')->url($logo_path) }}" alt="Current Logo" class="mt-1 h-16 object-contain">
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" color="primary">
                    {{ __('Mettre à jour') }}
                </flux:button>
            </div>
        </div>
    </form>
</div>
