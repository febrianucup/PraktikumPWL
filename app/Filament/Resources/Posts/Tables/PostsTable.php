<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filement\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('title')->sortable()->searchable()->toggleable(),
                TextColumn::make('slug')->sortable()->searchable()->toggleable(),
                TextColumn::make('category.name')->sortable()->searchable()->toggleable(),
                ColorColumn::make('color')->toggleable(),
                ImageColumn::make('image')->toggleable()
                ->disk('public'),
                IconColumn::make('published')->boolean()->toggleable(),
                TextColumn::make('created_at')->toggleable()
                ->label('Created At')
                ->dateTime()
                ->sortable(),
                TextColumn::make('tags')->label('tags')->toggleable(isToggledHiddenByDefault:true),
            ])->defaultSort('created_at', 'asc')
            ->filters([
                Filter::make('created_at')
                ->label('Creation Date')
                ->schema([
                DatePicker::make('created_at')
                ->label('Select Date'),
                ])
                ->query(function ($query, $data) {
                return $query->when(
                $data['created_at'],
                fn ($query, $date) => $query->whereDate('created_at', $date)
                );
                }),
                SelectFilter::make('category_id')
                    ->label('Select Category')
                    ->relationship('category', 'name')
                    ->preload(),
            ])
            ->recordActions([
                ReplicateAction::make(),
                EditAction::make(),
                ActionsDeleteAction::make(),
                Action::make('status')
                    ->label('Status Change')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                            Checkbox::make('published')
                            ->default(fn($record):bool=>$record->published),
                            ])
                    ->action(function ($record, $data) {
                        $record->update(['published' => $data['published']]);
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
