<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div style="margin-top: 1rem">
            <x-filament::button type="submit" wire:target="save" wire:loading.attr="disabled" :loading-indicator="true">
                {{ __('filament-panels::resources/pages/edit-record.form.actions.save.label') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
