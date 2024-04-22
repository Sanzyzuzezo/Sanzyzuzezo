<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUnitIdAndQuantityAfterConversionToSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_detail', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable();
            $table->decimal('quantity_after_conversion', 32, 4)->nullable();
            DB::statement('ALTER TABLE sales_detail ALTER COLUMN quantity TYPE DECIMAL(32, 4) USING quantity::DECIMAL(32, 4)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_detail', function (Blueprint $table) {
            //
        });
    }
}
