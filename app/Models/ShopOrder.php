<?php

namespace App\Models;

use App\Traits\ShopOrderVerify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ShopOrderVerify;

    protected $guarded = [];

    protected $table = 'shop_orders';
}
