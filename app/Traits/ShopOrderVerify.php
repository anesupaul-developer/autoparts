<?php

namespace App\Traits;

use App\Exceptions\CannotDeleteRecord;
use App\Models\ShopOrder;
use App\Pipelines\ShopOrderAutoAllocate;
use App\Pipelines\ShopOrderTotalCheck;
use App\Utilities\ShopOrder as ShopOrderUtil;
use Illuminate\Support\Facades\Pipeline;
use Exception;

trait ShopOrderVerify
{
    public static function bootShopOrderVerify(): void
    {
        static::creating(function ($model) {
            Pipeline::send($model)
                ->through([
                    ShopOrderAutoAllocate::class,
                    ShopOrderTotalCheck::class,
                ])
                ->then(fn (ShopOrder $shopOrder) => $shopOrder);
        });

        static::updating(function ($model) {
            Pipeline::send($model)
                ->through([
                    ShopOrderTotalCheck::class,
                ])
                ->then(fn (ShopOrder $shopOrder) => $shopOrder);
        });

        static::deleting(/**
         * @throws CannotDeleteRecord
         */ function ($model) {
           throw new CannotDeleteRecord();
        });
    }
}
