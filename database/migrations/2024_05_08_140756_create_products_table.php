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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->integer('product_type_id');
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->integer('sub_subcategory_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('product_code')->unique()->nullable();
            $table->string('name',191);
            $table->fullText('name'); // Used for searchable full text
            $table->string('slug',255)->unique();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->default(0);
            $table->longText('product_details')->nullable();
            $table->longText('product_specification')->nullable();
            $table->longText('product_compare')->nullable();
            $table->text('short_description')->nullable();
            $table->text('special_note')->nullable();
            $table->text('warranty')->nullable();
            $table->string('video_link')->nullable();
            $table->integer('view_count')->default(0);
            $table->string('thumbnail_path',255)->nullable();
            $table->string('product_unit')->nullable();
            $table->text('product_tags')->nullable();
            $table->boolean('is_exchangeable')->default(false);
            $table->boolean('is_refundable')->default(false);
            $table->string('contact_person', 50)->nullable();
            $table->enum('listed_on', ['featured', 'new-arrivals', 'best-selling'])->default('featured');
            $table->enum('request_status',['pending','approved'])->default("pending");
            $table->enum('status',['active','inactive'])->default("active");
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('products');
    }
};
