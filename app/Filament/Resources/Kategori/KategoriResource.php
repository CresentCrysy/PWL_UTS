<?php

namespace App\Filament\Resources\Kategori;

use App\Models\Kategori;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?int $navigationSort = 2;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informasi Kategori')->schema([
                Forms\Components\TextInput::make('kategori_kode')
                    ->label('Kode Kategori')
                    ->required()->maxLength(10)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('kategori_nama')
                    ->label('Nama Kategori')
                    ->required()->maxLength(100),
            ])->columns(2),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kategori_kode')->label('Kode')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('kategori_nama')->label('Nama Kategori')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('barangs_count')->label('Jumlah Barang')->counts('barangs')->sortable(),
        ])
        ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
        ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\Kategori\Pages\ListKategoris::route('/'),
            'create' => \App\Filament\Resources\Kategori\Pages\CreateKategori::route('/create'),
            'edit'   => \App\Filament\Resources\Kategori\Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
