<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seller_id')->nullable();
            $table->bigInteger('product_id');
            $table->string('sku');
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('discount_price')->nullable();
            $table->bigInteger('minimal_stock')->default(0);
            $table->bigInteger('stock')->default(0);
            $table->double('weight',40,2)->default(0);
            $table->text('dimensions')->nullable();
            $table->boolean("status");
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
        Schema::dropIfExists('product_variants');
    }
}
