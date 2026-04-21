<?php

namespace App\Filament\Resources\Stoks;
 
use App\Models\Stok;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
 
class StokResource extends Resource
{
    protected static ?string $model = Stok::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Stok Masuk';
    protected static ?int $navigationSort = 1;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Data Stok Masuk')->schema([
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(Supplier::pluck('supplier_nama', 'supplier_id'))
                    ->required()->searchable(),
 
                Forms\Components\Select::make('barang_id')
                    ->label('Barang')
                    ->options(Barang::pluck('barang_nama', 'barang_id'))
                    ->required()->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $barang = Barang::find($state);
                            $set('harga_beli_info', $barang ? 'Stok saat ini: ' . $barang->stok : '');
                        }
                    }),
 
                Forms\Components\Select::make('user_id')
                    ->label('User Penerima')
                    ->options(User::pluck('nama', 'user_id'))
                    ->required()
                    ->default(fn () => Filament::auth()->user()->user_id),
 
                Forms\Components\DateTimePicker::make('stok_tanggal')
                    ->label('Tanggal Penerimaan')
                    ->required()
                    ->default(now()),
 
                Forms\Components\TextInput::make('stok_jumlah')
                    ->label('Jumlah Stok')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ])->columns(2),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('barang.barang_kode')
                    ->label('Kode Barang')
                    ->searchable(),
 
                Tables\Columns\TextColumn::make('barang.barang_nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->badge()
                    ->color('success'),
 
                Tables\Columns\TextColumn::make('user.nama')
                    ->label('Diterima Oleh')
                    ->sortable(),
            ])
            ->defaultSort('stok_tanggal', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->options(Supplier::pluck('supplier_nama', 'supplier_id')),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStoks::route('/'),
            'create' => Pages\CreateStok::route('/create'),
            'edit'   => Pages\EditStok::route('/{record}/edit'),
        ];
    }
}