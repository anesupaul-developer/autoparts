<?php

namespace App\Models;

use App\Exceptions\CannotDeleteRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Utilities\ShopOrder as ShopOrderUtil;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'location'];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            $name = Str::of($model->getAttribute('name'))->trim()->lower();
            $columns = DB::connection()->getSchemaBuilder()->getColumnListing('shop_orders');

            if (!in_array($name, $columns)) {
                Schema::table('shop_orders', function (Blueprint $table) use($name) {
                    $table->bigInteger($name)->default(0);
                });
            }
        });

        static::deleting(function ($model) {
           throw new CannotDeleteRecord('Record cannot be deleted');
        });
    }
}
