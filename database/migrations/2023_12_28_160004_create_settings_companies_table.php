<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->text("value");
            $table->bigInteger('company_id');
            $table->dateTime('created_at', $precision = 0);
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
        Schema::dropIfExists('settings_companies');
    }
}
