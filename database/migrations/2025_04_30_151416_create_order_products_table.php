<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('seller_id');
            $table->integer('variant_id');
            $table->integer('product_id');
            $table->double('item_unit_price',8,2)->default(0);
            $table->double('item_discount_price',8,2)->default(0);
            $table->double('item_order_price',8,2)->default(0);
            $table->integer('quantity')->default(1);
            $table->double('item_total_unit_price',8,2)->default(0);
            $table->double('item_total_discount',8,2)->default(0);
            $table->double('item_total_order_price',8,2)->default(0);
            $table->string('size',50)->nullable();
            $table->string('color',50)->nullable();
            $table->enum('order_status',['pending','canceled','processing','shipped','delivered','returned'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
