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
        Schema::create('seller_shops', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->string('shop_name',191);
            $table->string('email',30)->unique()->nullable();
            $table->string('mobile',11)->unique()->nullable();
            $table->string('phone',20)->unique()->nullable();
            $table->string('address',500)->nullable();
            $table->date('start_from',5)->nullable();
            $table->string('licence_no',255)->nullable();
            $table->string('licence_file',255)->nullable()->comment('pdf');
            $table->string('website_url',255)->nullable();
            $table->string('logo',255)->nullable();
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
        Schema::dropIfExists('seller_shops');
    }
};
