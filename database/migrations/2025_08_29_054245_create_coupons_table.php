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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->enum('valid_for',['all-user','new-user']);
            $table->string('coupon_code',20)->unique();
            $table->enum('discount_type',['flat','percentage']);
            $table->integer('discount');
            $table->integer('used_limit')->default(1);
            $table->integer('minimum_cost')->default(0);
            $table->integer('up_to')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status',['active','inactive'])->default("active");
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
