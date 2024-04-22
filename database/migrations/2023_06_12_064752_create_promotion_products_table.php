<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('promotion_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_variant_id');
            $table->boolean('discount_type')->nullable();
            $table->bigInteger('discount_value')->nullable();
            $table->bigInteger('after_discount_price');
            $table->bigInteger('current_stock');
            $table->bigInteger('promotion_stock');
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
        Schema::dropIfExists('promotion_products');
    }
}
