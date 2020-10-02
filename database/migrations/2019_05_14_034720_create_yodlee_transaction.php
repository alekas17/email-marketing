<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYodleeTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yodlee_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer("user_id")->default(0);
            $table->integer("transaction_id")->default(0);
            $table->string("amount")->nullable();
            $table->string("currency")->nullable();
            $table->string("base_type")->nullable();
            $table->string("category_type")->nullable();
            $table->dateTime("transaction_date")->nullable();
            $table->string("account_id")->nullable();
            $table->string("merchant_name")->nullable();
            $table->longText("raw_yodlee_data")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yodlee_transactions');
    }
}
