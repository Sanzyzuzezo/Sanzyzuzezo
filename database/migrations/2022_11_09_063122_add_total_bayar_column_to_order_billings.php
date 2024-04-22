<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalBayarColumnToOrderBillings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_billings', function (Blueprint $table) {
            $table->integer('total_bayar')->nullable();
            $table->integer('change')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_billings', function (Blueprint $table) {
            $table->dropColumn('total_bayar');
            $table->dropColumn('change');
        });
    }
}
