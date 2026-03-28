<?php

namespace App\Filament\Resources\Posts\Schemas;

use Dom\Text;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\Title;

class PostForm
{
    public static function configure(Schema $schema):  Schema
    {
        return $schema
            ->components([
                //section 1
                Section::make('Post Details')
                    ->description('Fill in the details of the post')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Group::make([
                        TextInput::make('title')
                            // ->required()
                            // ->minLength(5)
                            ->rules(['required', 'min:5', 'max:50',])
                            ->validationMessages(['min' => 'Title minimal 5 karakter']),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord:true)
                            ->validationMessages([
                                'unique' => 'Slug harus unik dan tidak boleh sama']),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->preload()
                            ->required()
                            ->searchable(),
                        ColorPicker::make('color')
                        ])->columns(2),
                        MarkdownEditor::make('content'),
                    ])->columnSpan(2),//->columnSpanFull()

                Group::make([
                Section::make('Image Uploads')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('posts')
                            ->required(),
                    ]),
                // MarkdownEditor::make('content')
                // RichEditor::make('content'),
                Section::make('Meta Informations')
                    ->icon('heroicon-o-bookmark')
                    ->schema([
                        TagsInput::make('tags'),
                        Checkbox::make('published'),
                    ]),
                DatePicker::make('published_at')->columnSpanFull(),
                ])->columns(2)
            ])->columns(3);
    }
}
