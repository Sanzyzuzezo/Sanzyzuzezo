<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_card_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("stock_card_id");
            $table->bigInteger("item_id")->nullable();
            $table->bigInteger("item_variant_id");
            $table->string("quantity");
            $table->string("quantity_after_conversion")->nullable();
            $table->bigInteger("unit_id");
            $table->dateTime('created_at', $precision = 0)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at', $precision = 0)->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('canceled_at', $precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_card_detail');
    }
}
