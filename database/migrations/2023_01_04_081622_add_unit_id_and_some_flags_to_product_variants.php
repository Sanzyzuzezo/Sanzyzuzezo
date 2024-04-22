<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdAndSomeFlagsToProductVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('unit_id')->nullable();
            $table->boolean('ingredient')->nullable();
            $table->boolean('sale')->nullable();
            $table->boolean('bought')->nullable();
            $table->boolean('show_online_shop')->nullable();
            $table->boolean('show_pos')->nullable();
            $table->boolean('production')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('unit_id');
            $table->dropColumn('ingredient');
            $table->dropColumn('sale');
            $table->dropColumn('bought');
            $table->dropColumn('show_online_shop');
            $table->dropColumn('show_pos');
            $table->dropColumn('production');
        });
    }
}
