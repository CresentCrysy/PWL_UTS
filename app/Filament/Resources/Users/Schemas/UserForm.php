<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('level_id')
                    ->required()
                    ->numeric(),
                TextInput::make('username')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
            ]);
    }
}
