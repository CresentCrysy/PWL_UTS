<?php

namespace App\Filament\Resources\Users;

use App\Models\User;
use App\Models\Level;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
 
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'User';
    protected static ?int $navigationSort = 5;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informasi User')->schema([
                Forms\Components\Select::make('level_id')
                    ->label('Level')
                    ->options(Level::pluck('level_nama', 'level_id'))
                    ->required(),
                Forms\Components\TextInput::make('username')
                    ->label('Username')->required()->maxLength(20)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')->required()->maxLength(100),
                Forms\Components\TextInput::make('email')
                    ->label('Email')->email()->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
            ])->columns(2),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('username')->label('Username')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
            Tables\Columns\TextColumn::make('level.level_nama')->label('Level')->sortable(),
        ])
        ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
        ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\Users\Pages\ListUsers::route('/'),
            'create' => \App\Filament\Resources\Users\Pages\CreateUser::route('/create'),
            'edit'   => \App\Filament\Resources\Users\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
