<?php

namespace App\Filament\Imports;

use App\Models\ShopOrder;
use App\Utilities\ShopOrder as ShopOrderUtil;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ShopOrderImporter extends Importer
{
    protected static ?string $model = ShopOrder::class;

    public static function getColumns(): array
    {
        $shops = ShopOrderUtil::shops();
        $additional = [];

        foreach ($shops as $shop) {
            $additional[] = ImportColumn::make($shop)
                ->name($shop)
                ->label(str($shop)->upper());
        }

        $columns = array_merge([
            ImportColumn::make('order_number')
                ->label('Order Number')
                ->requiredMapping(),
            ImportColumn::make('part_number')
                ->requiredMapping()
                ->label('Part Number'),
            ImportColumn::make('reference')
                ->label('Reference')
                ->requiredMapping(),
            ImportColumn::make('quantity')
                ->label('Quantity')
                ->requiredMapping()
                ->integer(),
            ImportColumn::make('price')
                ->requiredMapping()
                ->label('Price')
                ->numeric(),
            ImportColumn::make('total')
                ->requiredMapping()
                ->label('Total')
                ->numeric(),
        ], $additional);

        return array_merge($columns, [
            ImportColumn::make('suma')
                ->label('Suma')
                ->requiredMapping()
                ->integer(),
            ImportColumn::make('package_size')
                ->label('Min qty, pcs')
                ->requiredMapping()
                ->integer(),
            ImportColumn::make('comment')
                ->label('Comment'),
        ]);
    }

    public function resolveRecord(): ?ShopOrder
    {
        // return ShopOrder::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ShopOrder();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your shop order import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
