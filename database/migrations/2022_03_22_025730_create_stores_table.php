<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("status");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("image")->nullable();
            $table->integer("province_id");
            $table->integer("city_id");
            $table->integer("subdistrict_id");
            $table->string("detail_address");
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
        Schema::dropIfExists('stores');
    }
}
