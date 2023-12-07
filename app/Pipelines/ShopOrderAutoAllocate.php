<?php

namespace App\Pipelines;

use App\Utilities\ShopOrder as ShopOrderUtil;
use Closure;

class ShopOrderAutoAllocate
{
    public function handle($shopOrder, Closure $next)
    {
        $shops = ShopOrderUtil::shops();

        $total = $shopOrder->quantity;
        $step = ceil($total / count($shops));

        foreach ($shops as $shop) {
            $val = $shopOrder->getAttribute($shop);
            if (! is_numeric($val)) {
                $total = $total - $step;
                if ($total <= $step && $total > -1) {
                    $shopOrder->setAttribute($shop, $total);
                } else {
                    $shopOrder->setAttribute($shop, $step);
                }
            }
        }

        return $next($shopOrder);
    }
}
