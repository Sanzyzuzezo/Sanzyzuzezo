<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLogAbsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_absen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_karyawan');
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_keluar');
            $table->string('telat')->nullable();
            $table->string('path_image_masuk');
            $table->string('path_image_keluar');
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
        Schema::dropIfExists('log_absen');
    }
}
