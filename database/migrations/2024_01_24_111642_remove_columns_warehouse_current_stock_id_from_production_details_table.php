<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsWarehouseCurrentStockIdFromProductionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_details', function (Blueprint $table) {
            $table->dropColumn('warehouse_id');
            $table->dropColumn('current_stock');
            $table->dropColumn('stock_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_details', function (Blueprint $table) {
            //
        });
    }
}
