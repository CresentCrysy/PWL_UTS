<?php

namespace App\Filament\Resources\SupplierResource;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Supplier';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informasi Supplier')
                ->schema([
                    Forms\Components\TextInput::make('supplier_kode')
                        ->label('Kode Supplier')
                        ->required()
                        ->maxLength(10)
                        ->unique(ignoreRecord: true)
                        ->placeholder('Contoh: SUP001'),

                    Forms\Components\TextInput::make('supplier_nama')
                        ->label('Nama Supplier')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\Textarea::make('supplier_alamat')
                        ->label('Alamat')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier_alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('stoks_count')
                    ->label('Jml Transaksi Stok')
                    ->counts('stoks')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index'  => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit'   => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}