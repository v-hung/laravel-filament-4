<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->copyMessageDuration(1500),
                TextEntry::make('description')->columnSpanFull(),
                TextEntry::make('content')
                    ->columnSpanFull()->html(),
                ImageEntry::make('images'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')->badge(),
            ]);
    }
}
