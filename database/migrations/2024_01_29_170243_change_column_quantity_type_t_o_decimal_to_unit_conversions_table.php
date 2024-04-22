<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnQuantityTypeTODecimalToUnitConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_conversions', function (Blueprint $table) {
            DB::statement('ALTER TABLE unit_conversions ALTER COLUMN quantity TYPE DECIMAL(32, 4) USING quantity::DECIMAL(32, 4)');
            DB::statement('ALTER TABLE unit_conversions ALTER COLUMN new_quantity TYPE DECIMAL(32, 4) USING new_quantity::DECIMAL(32, 4)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_conversions', function (Blueprint $table) {
            //
        });
    }
}
