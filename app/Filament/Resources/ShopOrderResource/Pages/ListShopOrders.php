<?php

namespace App\Filament\Resources\ShopOrderResource\Pages;

use App\Filament\Imports\OrderImporter;
use App\Filament\Imports\ShopOrderImporter;
use App\Filament\Resources\ShopOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopOrders extends ListRecords
{
    protected static string $resource = ShopOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Import Shop Orders')
                ->importer(ShopOrderImporter::class),
            Actions\CreateAction::make()
            ->label('New Shop Order'),
        ];
    }
}
