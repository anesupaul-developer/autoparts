<?php

namespace App\Filament\Resources\DashboardShopOrderResource\Widgets;

use App\Models\Shop;
use App\Models\ShopOrder;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ShopOrderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $tdy = Carbon::now()->startOfDay()->toDateString();
        $end = Carbon::now()->endOfDay()->toDateString();

        $shopOrders = ShopOrder::query()
            ->whereBetween('created_at', [$tdy, $end])
            ->count();

        $allOrders = ShopOrder::query()->count();

        $shops = Shop::query()->count();

        return [
            Stat::make('Shop Orders', Number::format($shopOrders))
                ->description('Total Orders Today')
                ->color('success'),
            Stat::make('Shops', Number::format($shops))
                ->description('Total Shops')
                ->color('info'),
            Stat::make('All Orders', Number::format($allOrders))
                ->description('Total Orders')
                ->color('warning')
        ];
    }
}
