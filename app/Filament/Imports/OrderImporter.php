<?php

namespace App\Filament\Imports;

use App\Models\Order;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class OrderImporter extends Importer
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('order_number')
                ->label('Order Number'),
            ImportColumn::make('part_number')
                ->label('Part Number'),
            ImportColumn::make('reference')
                ->label('Reference'),
            ImportColumn::make('quantity')
                ->label('Quantity')
                ->integer(),
            ImportColumn::make('price')
                ->label('Price')
                ->numeric(),
            ImportColumn::make('total')
                ->label('Total')
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?Order
    {
        // return Order::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Order();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your order import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
