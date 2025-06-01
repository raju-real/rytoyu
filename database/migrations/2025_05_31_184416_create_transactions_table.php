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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->string('unique_id');
            $table->string('order_number');
            $table->string('invoice');
            $table->string('gateway')->nullable();
            $table->string('transaction_id');
            $table->string('transaction_invoice',255)->nullable();
            $table->string('transaction_time');
            $table->string('transaction_ip')->nullable();
            $table->double('transaction_amount', 8, 2);
            $table->double('vat', 8, 2)->nullable();
            $table->double('store_amount', 8, 2)->nullable();
            $table->string('currency');
            $table->string('currency_type')->nullable();
            $table->string('currency_amount')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('status');
            $table->string('message')->nullable();
            $table->string('val_id')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_no')->nullable();
            $table->string('bank_tran_id')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('error')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_sub_brand')->nullable();
            $table->string('card_issuer_country')->nullable();
            $table->string('card_issuer_country_code')->nullable();
            $table->string('store_id')->nullable();
            $table->text('verify_sign')->nullable();
            $table->text('verify_key')->nullable();
            $table->text('verify_sign_sha2')->nullable();
            $table->text('base_fair')->nullable();
            $table->string('risk_level')->nullable();
            $table->string('risk_title')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('city_town')->nullable();
            $table->string('post_code')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
