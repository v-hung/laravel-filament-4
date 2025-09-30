<?php

namespace App\Filament\Forms\Components;

use Closure;
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

        $this->rules($this->validateState());
    }

    private function validateState(): array
    {
        return [
            $this->name . '.options' => 'array',
            $this->name . '.options.*.name' => 'required|string',
            $this->name . '.options.*.values' => 'array|min:1',
            $this->name . '.options.*.values.*.label' => 'required|string',

            $this->name . '.variants' => 'array',
            $this->name . '.variants.*.sku' => 'required|string',
            $this->name . '.variants.*.price' => 'required|numeric',
            $this->name . '.variants.*.values' => 'array|min:1',
        ];
    }
}
