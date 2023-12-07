<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopOrderResource\Pages;
use App\Models\ShopOrder;
use App\Utilities\ShopOrder as ShopOrderUtil;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
        $items = ShopOrderUtil::shops();

        $basicSection = [
            TextInput::make('order_number')
            ->label('Order Number'),
            TextInput::make('part_number')
                ->label('Part Number'),
            TextInput::make('reference')
                ->label('Reference'),
        ];

        $costSection = [
            TextInput::make('quantity')
                ->label('Quantity'),
            TextInput::make('total')
                ->label('Total'),
            TextInput::make('price')
                ->label('Price'),
            TextInput::make('suma')
                ->label('Suma'),
            TextInput::make('package_size')
                ->label('Package Size'),
        ];

        $shops = [];

        foreach ($items as $shop) {
            $shops[] = TextInput::make($shop)
                ->label(str($shop)->upper());
        }

        return $form
            ->schema([
                Section::make('Details')
                    ->description('Basic Order Information.')
                    ->schema($basicSection)->columns(3),
                Section::make('Costing')
                    ->description('Order costing.')
                    ->schema($costSection)->columns(5),
                Section::make('Notes')
                    ->description('Short note about the order.')
                ->schema([Textarea::make('comment')->label('Comment')])
                    ->columnSpanFull(),
                Section::make('Shop Allocation')
                    ->description('Allocation of items across group shops.')
                    ->schema($shops)
                    ->columns(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        $shops = ShopOrderUtil::shops();
        $allocation = [];

        foreach ($shops as $shop) {
            $allocation[] = Tables\Columns\TextColumn::make($shop)
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
                ->label('Total'),
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
