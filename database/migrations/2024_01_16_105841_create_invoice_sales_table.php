<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('sales_id');
            $table->foreignId('delivery_note_id');
            $table->bigInteger('total_payment_amount');
            $table->text('proof_of_payment')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
            $table->foreignId('updated_by')->nullable();
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_sales');
    }
}
