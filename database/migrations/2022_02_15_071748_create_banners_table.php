<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->boolean('same_as_default')->default(1);
            $table->string('title_an')->nullable();
            $table->string('caption_an')->nullable();
            $table->text('description_an')->nullable();
            $table->boolean('show_button');
            $table->text('button_text')->nullable();
            $table->text('button_url')->nullable();
            $table->text('image');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('banners');
    }
}
