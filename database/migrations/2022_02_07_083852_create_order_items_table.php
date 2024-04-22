<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seller_id')->nullable();
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_variant_id');
            $table->bigInteger('quantity');
            $table->bigInteger('price');
            $table->integer('discount_product')->nullable();
            $table->text('noted')->nullable();
            $table->dateTime('created_at', $precision = 0);
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
        Schema::dropIfExists('order_items');
    }
}
