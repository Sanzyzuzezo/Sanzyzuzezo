<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnQuantityTypeToDecimalToDeliveryNoteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_note_detail', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable();
            $table->decimal('quantity_after_conversion', 32, 4)->nullable();
            $table->decimal('quantity', 32, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_note_detail', function (Blueprint $table) {
            //
        });
    }
}
