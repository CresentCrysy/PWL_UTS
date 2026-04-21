<?php

namespace App\Filament\Resources\Penjualans;
 
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
 
class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Penjualan';
    protected static ?int $navigationSort = 2;
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Header Transaksi')->schema([
                Forms\Components\TextInput::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->default(fn () => 'PJL-' . date('YmdHis'))
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->readOnly(),
 
                Forms\Components\DateTimePicker::make('penjualan_tanggal')
                    ->label('Tanggal Transaksi')
                    ->required()
                    ->default(now()),
 
                Forms\Components\Select::make('user_id')
                    ->label('Kasir')
                    ->options(User::pluck('nama', 'user_id'))
                    ->required()
                    ->default(fn () => Filament::auth()->user()->user_id),
 
                Forms\Components\TextInput::make('pembeli')
                    ->label('Nama Pembeli')
                    ->maxLength(50)
                    ->placeholder('Opsional - Umum'),
            ])->columns(2),
 
            Schemas\Components\Section::make('Detail Barang')->schema([
                Forms\Components\Repeater::make('details')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('barang_id')
                            ->label('Barang')
                            ->options(
                                Barang::where('stok', '>', 0)
                                    ->get()
                                    ->mapWithKeys(fn ($b) => [
                                        $b->barang_id => "{$b->barang_kode} - {$b->barang_nama} (Stok: {$b->stok})"
                                    ])
                            )
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $barang = Barang::find($state);
                                    if ($barang) {
                                        $set('harga', $barang->harga_jual);
                                    }
                                }
                            }),
 
                        Forms\Components\TextInput::make('harga')
                            ->label('Harga Satuan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->reactive(),
 
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->reactive(),
 
                        Forms\Components\Placeholder::make('subtotal')
                            ->label('Subtotal')
                            ->content(function ($get): string {
                                $harga = (int) $get('harga');
                                $jumlah = (int) $get('jumlah');
                                return 'Rp ' . number_format($harga * $jumlah, 0, ',', '.');
                            }),
                    ])
                    ->columns(4)
                    ->addActionLabel('+ Tambah Barang')
                    ->minItems(1),
            ]),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penjualan_kode')
                    ->label('Kode Transaksi')
                    ->searchable()
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->default('Umum')
                    ->searchable(),
 
                Tables\Columns\TextColumn::make('user.nama')
                    ->label('Kasir')
                    ->sortable(),
 
                Tables\Columns\TextColumn::make('details_count')
                    ->label('Jml Item')
                    ->counts('details')
                    ->badge(),
 
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->getStateUsing(fn ($record) => 'Rp ' . number_format(
                        $record->details->sum(fn ($d) => $d->harga * $d->jumlah),
                        0, ',', '.'
                    ))
                    ->sortable(false),
            ])
            ->defaultSort('penjualan_tanggal', 'desc')
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn ($query) => $query->whereDate('penjualan_tanggal', today())),
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
 
    public static function getRelations(): array
    {
        return [];
    }
 
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit'   => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
