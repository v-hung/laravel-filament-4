<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PostForm
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
                    ->rules(fn(string $locale) => [
                        Rule::unique('posts', "slug->$locale")
                            ->ignore(fn($record) => $record?->id),
                    ]),
                TextInput::make('description')->maxLength(255),
                RichEditor::make('content')
                    ->columnSpan('full'),
                FileUpload::make('images')
                    ->multiple(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Published)
                    ->columnSpan('full'),
            ]);
    }
}
