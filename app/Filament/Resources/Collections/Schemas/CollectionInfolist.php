<?php

namespace App\Filament\Resources\Collections\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CollectionInfolist
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
                TextEntry::make('status')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
