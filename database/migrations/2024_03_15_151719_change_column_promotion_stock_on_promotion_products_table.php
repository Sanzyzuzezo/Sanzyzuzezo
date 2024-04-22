<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnPromotionStockOnPromotionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_products', function (Blueprint $table) {    
            $table->bigInteger('current_stock')->nullable()->change();
            $table->bigInteger('promotion_stock')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_products', function (Blueprint $table) {    
            //
        });
    }
}
