<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjusmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjusment_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("adjusment_id");
            $table->bigInteger("item_id")->nullable();
            $table->bigInteger("item_variant_id");
            $table->string("current_stock");
            $table->string("new_stock");
            $table->string("difference");
            $table->text("note");
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
        Schema::dropIfExists('adjusment_detail');
    }
}
