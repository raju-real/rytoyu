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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 10)->unique();
            $table->string('order_number')->unique();
            $table->string('invoice')->unique();
            $table->integer('user_id');
            $table->double('total_item_unit_price', 8, 2)->default(0);
            $table->double('total_item_discount', 8, 2)->default(0);
            $table->double('total_item_order_price', 8, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->double('coupon_discount_amount', 8, 2)->default(0);
            $table->double('shipping_fee', 8, 2)->default(0);
            $table->double('service_charge', 8, 2)->default(0); // For online payment
            $table->double('total_vat', 8, 2)->default(0);
            $table->double('total_discount',8,2);
            $table->double('total_order_price',8,2);
            $table->enum('order_status',['pending','canceled','processing','complete'])->default('pending');
            $table->enum('payment_method',['cash-on-delivery','online-payment'])->default('cash-on-delivery');
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->double('paid_amount', 8, 2)->default(0);
            $table->double('due_amount', 8, 2)->default(0);
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('email',50)->nullable();
            $table->integer('district_id')->nullable();
            $table->string('city_town')->nullable();
            $table->text('address')->nullable();
            $table->integer('post_code')->nullable();
            $table->text('additional_information')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
