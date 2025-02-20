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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('slug',191);
            $table->string('icon',255)->nullable();
            $table->string('image',255)->nullable();
            $table->enum('status',['active','inactive'])->default("active");
            $table->double('commission_rate',3,2)->default(0.00);
            $table->enum('is_mega_menu',['yes','no'])->default("no");
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('sorting_serial')->default(1);
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
        Schema::dropIfExists('categories');
    }
};
