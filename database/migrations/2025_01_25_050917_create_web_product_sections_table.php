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
        Schema::create('web_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_slug');
            $table->string('section_title');
            $table->string('section_module')->default('custom');
            $table->enum('section_for',['product','category','campaign','advertisement'])->default("product");
            $table->integer('category_id')->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('advertisement_id')->nullable();
            $table->enum('status',['active','inactive'])->default("inactive");
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
        Schema::dropIfExists('web_product_sections');
    }
};
