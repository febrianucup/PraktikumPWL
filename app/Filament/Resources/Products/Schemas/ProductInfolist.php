<?php

namespace App\Filament\Resources\Products\Schemas;

use Closure;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->columnSpanFull()
                    ->vertical()
                    ->tabs([
                        Tab::make('Product Details')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),
                            TextEntry::make('id')
                            ->label('Product ID'),
                            TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('info'),
                            TextEntry::make('description')
                            ->label('Product Description'),
                            TextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->date('d M Y')
                            ->color('info'),
                            ]),
                        Tab::make('Product Price and Stock')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                ->badge(fn():Closure => function (String $var, Closure $badge){
                                    if($var<=0){
                                        $badge('danger');
                                    }elseif($var<=20){
                                        $badge('warning');
                                    }else{
                                        $badge('success');
                                    }
                                })
                                ->label('Product Stock')
                                ->icon('heroicon-o-shopping-cart'),
                            ]),
                        Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                            ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public'),
                            IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                            IconEntry::make('is_featured')
                            ->label('Featured')
                            ->boolean(),
                            ]),         
                        ]),
                Section::make('Product Info')
                    ->schema([
                    TextEntry::make('name')
                    ->label('Product Name')
                    ->weight('bold')
                    ->color('primary'),
                    TextEntry::make('id')
                    ->label('Product ID'),
                    TextEntry::make('sku')
                    ->label('Product SKU')
                    ->badge()
                    ->color('info'),
                    TextEntry::make('description')
                    ->label('Product Description'),
                    TextEntry::make('created_at')
                    ->label('Product Creation Date')
                    ->date('d M Y')
                    ->color('info'),
                    ])->columnSpanFull(),
                Section::make('Pricing & Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->icon('heroicon-o-currency-dollar')
                            ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                        TextEntry::make('stock')
                        ->label('Product Stock')
                        ->icon('heroicon-o-shopping-cart'),
                    ])->columnSpanFull(),
                Section::make('Image and Status')
                    ->schema([
                        ImageEntry::make('image')
                        ->label('Product Image')
                        ->disk('public'),
                        TextEntry::make('price')
                        ->label('Product Price')
                        ->icon('heroicon-o-currency-dollar'),
                        TextEntry::make('stock')
                        ->label('Product Stock'),
                        IconEntry::make('is_active')
                            ->label('Is Active')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Is Featured')
                            ->boolean(),
                    ])->columnSpanFull(),
                
            ]);
    }
}
