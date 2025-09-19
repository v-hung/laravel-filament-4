<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
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
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('compare_at_price')
                    ->numeric(),
                TextEntry::make('stock_quantity')
                    ->numeric(),
                TextEntry::make('status')
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
