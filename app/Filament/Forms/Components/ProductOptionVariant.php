<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class ProductOptionVariant extends Field
{
    protected string $view = 'filament.forms.components.product-option-variant';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([
            'options' => [],
            'variants' => [],
        ]);

        $this->dehydrated(false);
    }
}
