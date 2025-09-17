<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\CategoryStatus;
use App\Enums\ContentStatus;
use App\Filament\Resources\Blogs\Schemas\BlogForm;
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
                    ->rules(function ($livewire, $record) {
                        $locale = $livewire->activeLocale ?? app()->getLocale();

                        return [
                            Rule::unique('posts', "slug->$locale")
                                ->ignore($record?->id),
                        ];
                    }),
                TextInput::make('description')->maxLength(255)->columnSpan('full'),
                RichEditor::make('content')
                    ->json()
                    ->columnSpan('full')
                    ->extraInputAttributes(['style' => 'min-height: 20rem;']),
                FileUpload::make('images')
                    ->multiple(),
                Select::make('blogs')
                    ->relationship('blogs', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Published),
            ]);
    }
}
