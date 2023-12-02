<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;

class ShopOrder
{
    public static function shops(): array
    {
        $columns = DB::connection()->getSchemaBuilder()->getColumnListing('shop_orders');

        $ignoreColumns = [
            'id', 'order_number', 'part_number', 'reference', 'quantity', 'price',
            'total', 'suma', 'package_size', 'comment', 'deleted_at', 'created_at', 'updated_at'
        ];

        return array_diff($columns, $ignoreColumns);
    }
}
