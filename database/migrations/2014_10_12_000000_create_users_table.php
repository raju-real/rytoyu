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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email',50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile',20)->unique();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('city',50)->nullable();
            $table->string('zip_code',20)->nullable();
            $table->text('home_address')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('image',255)->nullable();
            $table->enum('status',['active','inactive'])->default("active");
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
        Schema::dropIfExists('users');
    }
};
