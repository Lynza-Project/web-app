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
                    <flux:select id="primary" wire:model.live="primary" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($primary)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $primary }}"></div>
                    @endif
                    @error('primary') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="danger">{{ __('Couleur danger') }}</flux:label>
                    <flux:select id="danger" wire:model.live="danger" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($danger)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $danger }}"></div>
                    @endif
                    @error('danger') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label for="gray">{{ __('Couleur grise') }}</flux:label>
                    <flux:select id="gray" wire:model.live="gray" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($gray)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $gray }}"></div>
                    @endif
                    @error('gray') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="info">{{ __('Couleur info') }}</flux:label>
                    <flux:select id="info" wire:model.live="info" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($info)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $info }}"></div>
                    @endif
                    @error('info') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label for="success">{{ __('Couleur succès') }}</flux:label>
                    <flux:select id="success" wire:model.live="success" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($success)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $success }}"></div>
                    @endif
                    @error('success') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="warning">{{ __('Couleur avertissement') }}</flux:label>
                    <flux:select id="warning" wire:model.live="warning" required>
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($warning)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $warning }}"></div>
                    @endif
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
                    <flux:select id="background_color" wire:model.live="background_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($background_color)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $background_color }}"></div>
                    @endif
                    @error('background_color') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="text_color">{{ __('Couleur de texte') }}</flux:label>
                    <flux:select id="text_color" wire:model.live="text_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($text_color)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $text_color }}"></div>
                    @endif
                    @error('text_color') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="button_color">{{ __('Couleur de bouton') }}</flux:label>
                    <flux:select id="button_color" wire:model.live="button_color">
                        <option value="">{{ __('Sélectionner une couleur') }}</option>
                        @foreach(\App\Models\Theme::getColorOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    @if($button_color)
                        <div class="mt-2 h-6 w-6 rounded border border-gray-300 bg-{{ $button_color }}"></div>
                    @endif
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
