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
        Schema::create('vendor_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->double('amount', 8, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('admin_id')->nullable()->comment('ID of admin who approved/rejected');
            $table->string('transaction_method')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();

            // Note: the admins table has the integer id, not bigIncrements but we use bigInteger for compatibility 
            // We just ensure it's recorded correctly.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_payouts');
    }
};
