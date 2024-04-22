<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("code");
            $table->string("name");
            $table->integer("city_id");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("contact_pic")->nullable();
            $table->string("pic_phone")->nullable();
            $table->longText("detail_address")->nullable();
            $table->longText("note")->nullable();
            $table->boolean('status')->default(1);
            $table->dateTime('created_at', $precision = 0)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at', $precision = 0)->nullable();
            $table->bigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
