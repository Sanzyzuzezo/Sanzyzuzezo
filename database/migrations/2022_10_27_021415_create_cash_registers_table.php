<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('cash_in_hand');
            $table->string('status');
            $table->integer('total_cash')->nullable();
            $table->integer('total_cheques')->nullable();
            $table->integer('total_cc_slips')->nullable();
            $table->integer('total_cash_submitted')->nullable();
            $table->integer('total_cheques_submitted')->nullable();
            $table->integer('total_cc_slips_submitted')->nullable();
            $table->text('note')->nullable();
            $table->datetime('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_registers');
    }
}
