<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbackTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->default(0);
            $table->string("amount")->nullable();
            $table->integer("merchant_id")->default(0);
            $table->string("status")->nullable();
            $table->string("basiq_transaction_id")->nullable();
            $table->timestamps();
        });

        Schema::create('cashback_merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable();
            $table->string("cashback_percent")->nullable();
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
    }
}
