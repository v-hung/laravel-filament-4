<?php

namespace App\Filament\Forms\Components;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait HasProductOptionVariant
{
    public $tmpFile;
    public $variantFiles = [];

    public function customUpload(string $id)
    {
        if ($this->tmpFile instanceof TemporaryUploadedFile) {

            $this->variantFiles[$id] = $this->tmpFile;

            // Trả về URL tạm (preview được)
            return $this->tmpFile->temporaryUrl();

            // hoặc trả về đường dẫn file tạm
            // return $this->tmpFile->getRealPath();
        }

        return null;
    }
}
