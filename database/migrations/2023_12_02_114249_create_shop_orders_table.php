<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('part_number');
            $table->string('reference');
            $table->bigInteger('quantity');
            $table->decimal('price', 18);
            $table->decimal('total', 18);
            $table->bigInteger('suma');
            $table->bigInteger('package_size');
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['order_number', 'part_number', 'reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_orders');
    }
};
