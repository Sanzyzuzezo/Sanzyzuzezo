<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_stock', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("item_id")->nullable();
            $table->bigInteger("item_variant_id")->nullable();
            $table->bigInteger("store_id")->nullable();
            $table->string("stock")->nullable();
            $table->dateTime('created_at', $precision = 0)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at', $precision = 0)->nullable();
            $table->bigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_stock');
    }
}
