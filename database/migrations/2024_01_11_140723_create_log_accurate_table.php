<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAccurateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_accurate', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('company_id');
            $table->text('data');
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('log_accurate');
    }
}
