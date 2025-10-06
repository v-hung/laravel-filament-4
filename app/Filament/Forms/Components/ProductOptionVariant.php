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

        $this->rules($this->validateStateRules());
    }

    private function validateStateRules(): \Closure
    {
        return fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
            $validator = \Illuminate\Support\Facades\Validator::make($value, [
                'options' => 'array',
                'options.*.name' => 'required|string',
                'options.*.values' => 'array|min:1',
                'options.*.values.*.id' => 'required',
                'options.*.values.*.label' => 'required|string',

                'variants' => 'array',
                'variants.*.sku' => 'string',
                'variants.*.price' => 'required|numeric',
                'variants.*.stock' => 'numeric',
                'variants.*.values' => 'array|min:1',
                'variants.*.values.*.option_id' => 'required',
                'variants.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120'
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $key => $messages) {
                    foreach ($messages as $message) {
                        $prefixedKey = 'data.' . $this->name . '.' . $key;
                        $fail($prefixedKey, $message);
                    }
                }
            }
        };
    }
}
