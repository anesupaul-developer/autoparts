<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopOrderResource\Pages;
use App\Models\ShopOrder;
use App\Utilities\ShopOrder as ShopOrderUtil;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShopOrderResource extends Resource
{
    protected static ?string $model = ShopOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Inventory Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $shops = ShopOrderUtil::shops();
        $allocation = [];

        foreach ($shops as $shop) {
            $allocation[] =  Tables\Columns\TextColumn::make($shop)
                ->toggleable(isToggledHiddenByDefault: true)
                ->label(str($shop)->upper());
        }

        $initial = [
            Tables\Columns\TextColumn::make('order_number')
                ->label('Order Number'),
            Tables\Columns\TextColumn::make('part_number')
                ->label('Part Number'),
            Tables\Columns\TextColumn::make('reference')
                ->label('Reference Number'),
            Tables\Columns\TextColumn::make('quantity')
                ->label('Quantity Number'),
            Tables\Columns\TextColumn::make('price')
                ->label('Price'),
            Tables\Columns\TextColumn::make('total')
                ->label('Total')
        ];

        $data = array_merge(array_merge($initial, $allocation), [
            Tables\Columns\TextColumn::make('suma')
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Suma'),
            Tables\Columns\TextColumn::make('package_size')
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Package Size'),
            Tables\Columns\TextColumn::make('comment')
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Comment'),
        ]);

        return $table
            ->columns($data)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShopOrders::route('/'),
            'create' => Pages\CreateShopOrder::route('/create'),
            'edit' => Pages\EditShopOrder::route('/{record}/edit'),
        ];
    }
}
