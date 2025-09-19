<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->rules(function ($livewire, $record) {
                        $locale = $livewire->activeLocale ?? app()->getLocale();

                        return [
                            Rule::unique('products', "slug->$locale")
                                ->ignore($record?->id),
                        ];
                    }),
                TextInput::make('description')->maxLength(255)->columnSpan('full'),
                RichEditor::make('content')
                    ->columnSpan('full')
                    ->extraInputAttributes(['style' => 'min-height: 20rem;']),
                FileUpload::make('images')
                    ->multiple(),
                TextInput::make('compare_at_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('collections')
                    ->relationship('collections', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options(ProductStatus::class)
                    ->default(ProductStatus::Active),
            ]);
    }
}
