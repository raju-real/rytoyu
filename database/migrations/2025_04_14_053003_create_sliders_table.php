<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('highlighted_title', 100)->nullable();
            $table->string('caption', 100)->nullable();
            $table->string('highlighted_caption', 100)->nullable();
            $table->string('slug',255);
            $table->string('image_path', 255)->nullable();
            $table->string('redirect_link')->nullable();
            $table->string('button_name')->nullable();
            $table->enum('status', ['active', 'inactive'])->default("active");
            $table->integer('sorting_serial')->default(0);
            $table->integer('created_by');
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
        Schema::dropIfExists('sliders');
    }
};
