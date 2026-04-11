<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard as ComponentsWizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use SebastianBergmann\CodeUnitReverseLookup\Wizard;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsWizard::make([
                    Step::make('Product Info')
                        ->description('ISi Informasi Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('name')->required(),
                                TextInput::make('sku')->required(),
                            ])->columns(2),
                            MarkdownEditor::make('desription')
                        ]),
                    Step::make('Product Price and Stock')
                        ->description('Isi Harga Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('price')->required()->numeric(),
                                TextInput::make('stock')->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                        ]),
                    Step::make('Media and Status')
                        ->description('Isi Gambar Produk')
                        ->schema([
                            FileUpload::make('image')
                            ->disk('public')
                            ->directory('posts'),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ])
                ])
                ->columnSpanFull()
                ->submitAction(
                    Action::make('save')
                        ->label('Save Product')
                        ->button()
                        ->color('primary')
                        ->submit('save')
                )
            ]);
    }
}
