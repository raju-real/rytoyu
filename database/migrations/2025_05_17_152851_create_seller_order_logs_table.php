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
        Schema::create('seller_order_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->string('order_id');
            $table->string('order_number');
            $table->string('invoice');
            $table->integer('total_product')->default(0);
            $table->double('order_amount')->default(0.00);
            $table->double('commission_rate',8,2)->default(0.00);
            $table->double('total_commission')->default(0.00);
            $table->enum('payment_status',['paid','unpaid'])->default("unpaid");
            $table->timestamps();
            $table->unique(['seller_id', 'order_id', 'order_number', 'invoice']); // To ensure uniqueness
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_order_logs');
    }
};
