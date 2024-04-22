<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->string('invoice_number');
            $table->string('status');
            $table->dateTime('transaction_date');
            $table->integer('discount_order')->nullable();
            $table->integer('discount_customer')->nullable();
            $table->foreignId('total');
            $table->foreignId('old_total');
            $table->text('note')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('created_at', $precision = 0);
            $table->foreignId('created_by')->nullable();
            $table->dateTime('updated_at', $precision = 0)->nullable();
            $table->foreignId('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
