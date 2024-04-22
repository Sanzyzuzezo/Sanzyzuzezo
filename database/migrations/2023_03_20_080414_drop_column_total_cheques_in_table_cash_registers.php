<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnTotalChequesInTableCashRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->dropColumn('total_cheques')->nullable();
            $table->dropColumn('total_cc_slips')->nullable();
            $table->dropColumn('total_cash_submitted')->nullable();
            $table->dropColumn('total_cheques_submitted')->nullable();
            $table->dropColumn('total_cc_slips_submitted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->integer('total_cheques')->nullable();
            $table->integer('total_cc_slips')->nullable();
            $table->integer('total_cash_submitted')->nullable();
            $table->integer('total_cheques_submitted')->nullable();
            $table->integer('total_cc_slips_submitted')->nullable();
        });
    }
}
