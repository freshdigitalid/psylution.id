<x-filament::page>
    <div class="space-y-6">
        <div class="space-y-4">
            {{ $this->profileForm }}
            <x-filament::button wire:click="saveProfile">
                Save Profile
            </x-filament::button>
        </div>

        <div class="space-y-4">
            {{ $this->passwordForm }}
            <x-filament::button wire:click="savePassword">
                Update Password
            </x-filament::button>
        </div>
    </div>
</x-filament::page>
