<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
// use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord:true),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->rule(Password::min(6))
                    ->visibleOn('create')
            ]);
    }
}
