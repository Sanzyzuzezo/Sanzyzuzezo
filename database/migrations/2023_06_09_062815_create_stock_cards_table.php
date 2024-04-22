<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_card', function (Blueprint $table) {
            $table->id();
            $table->date("date")->nullable();
            $table->string("transaction_type");
            $table->bigInteger("warehouse_id");
            $table->bigInteger("destination_warehouse_id")->nullable();
            $table->bigInteger("store_id")->nullable();
            $table->boolean("status");
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
        Schema::dropIfExists('stock_card');
    }
}
