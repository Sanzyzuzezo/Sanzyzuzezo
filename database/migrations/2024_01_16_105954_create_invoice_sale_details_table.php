<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_sales_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_sales_id');
            $table->foreignId('item_variant_id');
            $table->bigInteger('quantity');
            $table->bigInteger('total_payment');
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
        Schema::dropIfExists('invoice_sale_details');
    }
}
