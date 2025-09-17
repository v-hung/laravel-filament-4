<?php

namespace App\Filament\Resources\Blogs\Schemas;

use App\Enums\CategoryStatus;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogForm
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
                            Rule::unique('blogs', "slug->$locale")
                                ->ignore($record?->id),
                        ];
                    }),
                TextInput::make('description')->maxLength(255)->columnSpan('full'),
                Select::make('status')
                    ->options(CategoryStatus::class)
                    ->default(CategoryStatus::Active),
            ]);
    }
}
