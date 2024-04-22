<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInTableOrderShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shippings', function (Blueprint $table) {
            $table->string('new_resi')->nullable();
            $table->bigInteger('new_cost')->nullable();
            $table->boolean('instant_waybill')->nullable();
            $table->text('origin_address')->nullable();
            $table->string('status')->nullable();
            $table->text('data')->nullable();
            $table->text('data_status')->nullable();
            $table->text('data_price')->nullable();
            $table->text('data_waybill')->nullable();
            $table->bigInteger('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_shippings', function (Blueprint $table) {
            //
        });
    }
}
