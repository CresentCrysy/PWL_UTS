<?php

namespace App\Filament\Resources\Barangs;
 
use App\Models\Barang;
use App\Models\Kategori;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
 
class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Barang';
    protected static ?int $navigationSort = 3;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informasi Barang')->schema([
                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::pluck('kategori_nama', 'kategori_id'))
                    ->required()->searchable(),
                Forms\Components\TextInput::make('barang_kode')
                    ->label('Kode Barang')->required()->maxLength(10)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('barang_nama')
                    ->label('Nama Barang')->required()->maxLength(100)->columnSpanFull(),
                Forms\Components\TextInput::make('harga_beli')
                    ->label('Harga Beli')->required()->numeric()->prefix('Rp'),
                Forms\Components\TextInput::make('harga_jual')
                    ->label('Harga Jual')->required()->numeric()->prefix('Rp'),
                Forms\Components\TextInput::make('stok')
                    ->label('Stok Awal')->required()->numeric()->default(0)->minValue(0),
            ])->columns(2),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('barang_kode')->label('Kode')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('barang_nama')->label('Nama Barang')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('kategori.kategori_nama')->label('Kategori')->sortable(),
            Tables\Columns\TextColumn::make('harga_beli')->label('Harga Beli')
                ->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('harga_jual')->label('Harga Jual')
                ->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('stok')->label('Stok')
                ->sortable()
                ->badge()
                ->color(fn ($state) => $state <= 10 ? 'danger' : ($state <= 30 ? 'warning' : 'success')),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('kategori_id')
                ->label('Kategori')
                ->options(Kategori::pluck('kategori_nama', 'kategori_id')),
        ])
        ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
        ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\Barangs\Pages\ListBarangs::route('/'),
            'create' => \App\Filament\Resources\Barangs\Pages\CreateBarang::route('/create'),
            'edit'   => \App\Filament\Resources\Barangs\Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
