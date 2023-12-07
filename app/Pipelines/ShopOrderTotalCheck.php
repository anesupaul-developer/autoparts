<?php

namespace App\Pipelines;

use App\Utilities\ShopOrder as ShopOrderUtil;
use Closure;
use Exception;

class ShopOrderTotalCheck
{
    /**
     * @throws Exception
     */
    public function handle($shopOrder, Closure $next)
    {
        $shops = ShopOrderUtil::shops();
        $total = 0;
        foreach ($shops as $shop) {
            $total += $shopOrder->getAttribute($shop);
        }

        if ($total - intval($shopOrder->getAttribute('suma')) != 0 ||
            intval($shopOrder->getAttribute('quantity')) - intval($shopOrder->getAttribute('suma')) != 0) {
            throw new Exception('Total is '.$shopOrder->getAttribute('suma').
                ' but order totals is '.$total.' and order is '.$shopOrder->getAttribute('quantity'));
        }

        return $next($shopOrder);
    }
}
