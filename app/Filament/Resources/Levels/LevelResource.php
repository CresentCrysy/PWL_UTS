<?php

namespace App\Filament\Resources\Levels;

use App\Models\Level;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
 
class LevelResource extends Resource
{
    protected static ?string $model = Level::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Level User';
    protected static ?int $navigationSort = 4;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informasi Level')->schema([
                Forms\Components\TextInput::make('level_kode')
                    ->label('Kode Level')->required()->maxLength(10)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('level_nama')
                    ->label('Nama Level')->required()->maxLength(100),
            ])->columns(2),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('level_kode')->label('Kode')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('level_nama')->label('Nama Level')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('users_count')->label('Jumlah User')->counts('users')->sortable(),
        ])
        ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
        ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\Levels\Pages\ListLevels::route('/'),
            'create' => \App\Filament\Resources\Levels\Pages\CreateLevel::route('/create'),
            'edit'   => \App\Filament\Resources\Levels\Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}