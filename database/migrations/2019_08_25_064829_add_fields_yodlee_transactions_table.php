<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsYodleeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yodlee_transactions', function (Blueprint $table) {
            $table->string("container")->nullable();
            $table->integer("category_id")->nullable();
            $table->string("category")->nullable();
            $table->string("category_source")->nullable();
            $table->bigInteger("high_level_category_id")->nullable();
            $table->dateTimeTz("created_date")->nullable();
            $table->dateTimeTz("last_updated")->nullable();
            $table->string("description_original")->nullable();
            $table->string("description_simple")->nullable();
            $table->string("type")->nullable();
            $table->string("sub_type")->nullable();
            $table->boolean("is_manual")->nullable();
            $table->string("source_type")->nullable();
            $table->dateTime("date")->nullable();
            $table->dateTime("post_date")->nullable();
            $table->string("status")->nullable();
            $table->string("merchant_source")->nullable();
            $table->string("merchant_category_label")->nullable();
            $table->string("merchant_address_city")->nullable();
            $table->string("merchant_address_state")->nullable();
            $table->string("merchant_address_country")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yodlee_transactions', function (Blueprint $table) {
            $table->dropColumn("container");
            $table->dropColumn("category_id");
            $table->dropColumn("category");
            $table->dropColumn("category_source");
            $table->dropColumn("high_level_category_id");
            $table->dropColumn("created_date");
            $table->dropColumn("last_updated");
            $table->dropColumn("description_original");
            $table->dropColumn("description_simple");
            $table->dropColumn("type");
            $table->dropColumn("sub_type");
            $table->dropColumn("is_manual");
            $table->dropColumn("source_type");
            $table->dropColumn("date");
            $table->dropColumn("post_date");
            $table->dropColumn("status");
            $table->dropColumn("merchant_source");
            $table->dropColumn("merchant_category_label");
            $table->dropColumn("merchant_address_city");
            $table->dropColumn("merchant_address_state");
            $table->dropColumn("merchant_address_country");
        });
    }
}
