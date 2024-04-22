<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuysDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buys_id');
            $table->bigInteger('product_variant_id');
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->string("jumlah")->nullable();
            $table->string("total")->nullable();
            $table->date("expired")->nullable();
            $table->longText("image")->nullable();
            $table->boolean("status")->nullable()->default(1);
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
        Schema::dropIfExists('buys_detail');
    }
}
