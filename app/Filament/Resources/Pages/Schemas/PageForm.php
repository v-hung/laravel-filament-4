<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('content'),
                TextInput::make('images'),
                TextInput::make('status'),
            ]);
    }
}
