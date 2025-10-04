<?php

namespace App\Filament\Forms\Components;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * @property \App\Models\Product $record
 */
trait HasProductOptionVariant
{

    public array $optionVariantCache = [];

    protected function afterFill(): void
    {
        if ($this->record) {
            $product = app(ProductRepository::class)->withOptionsAndVariants($this->record);

            $this->form->fill([
                ...$this->form->getRawState(),
                'option_variant' => [
                    'options' => $product->options_raw,
                    'variants' => $product->variants_raw,
                ],
            ]);
        }
    }

    protected function beforeValidate(): void
    {
        $state = $this->form->getRawState()['option_variant'] ?? null;

        $this->form->fill([
            ...$this->form->getRawState(),
            'has_variant' => !empty($state['variants'] ?? [])
        ]);

        $this->optionVariantCache = $this->form->getRawState()['option_variant'] ?? [];
    }

    protected function afterCreate(): void
    {
        $this->saveOptionVariant();
    }

    protected function afterSave(): void
    {
        $this->saveOptionVariant();
    }

    private function saveOptionVariant()
    {
        try {
            $state = $this->optionVariantCache;

            if ($state) {
                app(ProductService::class)->saveOptionsVariants(
                    $state['options'] ?? [],
                    $state['variants'] ?? [],
                    $this->record->id
                );
            }
        } catch (ValidationException $e) {
            Notification::make()
                ->warning()
                ->title('You don\'t have an active subscription!')
                ->body('Choose a plan to continue.')
                ->persistent()
                ->send();

            $this->halt();
        } finally {
            $this->optionVariantCache = [];
        }
    }
}
