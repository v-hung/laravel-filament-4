<?php

namespace App\Filament\Forms\Components;

use App\Repositories\ProductRepository;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * @property \App\Models\Product $record
 */
trait HasProductOptionVariant
{
    public $tmpFile;
    public $variantFiles = [];

    public function variantUploadFile(string $id)
    {
        if ($this->tmpFile instanceof TemporaryUploadedFile) {

            $this->variantFiles[$id] = $this->tmpFile;

            return $this->tmpFile->temporaryUrl();
        }

        return null;
    }

    public function variantRemoveFile(string $id)
    {
        if (isset($this->variantFiles[$id])) {
            unset($this->variantFiles[$id]);
            return true;
        }

        return false;
    }

    protected function afterFill(): void
    {
        if ($this->record) {
            $product = app(ProductRepository::class)->withOptionsAndVariants($this->record);

            $this->form->fill([
                'option_variant' => [
                    'options' => $product->options_raw,
                    'variants' => $product->variants_raw,
                ],
            ]);
        }
    }

    protected function afterCreate(): void
    {
        DB::beginTransaction();

        try {
            $state = $this->form->getState()['option_variant'] ?? null;

            if ($state) {
                foreach ($state['options'] as $option) {
                    if (empty($option)) {
                        throw ValidationException::withMessages([
                            'option_variant.options' => 'Tên option không được để trống.',
                        ]);
                    }
                    $this->record->options()->create(['name' => $option]);
                }
            }

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            Notification::make()
                ->warning()
                ->title('You don\'t have an active subscription!')
                ->body('Choose a plan to continue.')
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}
