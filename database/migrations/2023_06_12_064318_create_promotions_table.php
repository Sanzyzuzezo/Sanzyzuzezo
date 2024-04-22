<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('discount_type')->nullable();
            $table->bigInteger('discount_value')->nullable();
            $table->text('image');
            $table->boolean('status')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
