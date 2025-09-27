<?php

namespace App\Filament\Forms\Components;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
}
