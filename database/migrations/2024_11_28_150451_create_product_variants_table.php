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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('size_id')->nullable();
            $table->integer('color_id')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->default(0);
            $table->string('image',255)->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('inventory')->default(0);
            $table->integer('alert_quantity')->default(0);
            $table->decimal('weight', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
