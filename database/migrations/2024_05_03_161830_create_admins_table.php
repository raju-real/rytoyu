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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->enum('type',['administrator','admin','seller']);
            $table->integer('role_id')->nullable();
            $table->string('name',191);
            $table->string('email',30)->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('mobile',11)->unique()->nullable();
            $table->string('verification_code',6)->nullable();
            $table->dateTime('mobile_verified_at')->nullable();
            $table->string('password_plain',15);
            $table->string('password',400);
            $table->double('commission_rate',8,2)->default(0.00);
            $table->rememberToken();
            $table->string('image',255)->nullable();
            $table->enum('status',['active','inactive'])->default("active");
            $table->enum('request_status',['pending','approved'])->default("pending");
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('last_logout_at')->nullable();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('password_reset_code')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
