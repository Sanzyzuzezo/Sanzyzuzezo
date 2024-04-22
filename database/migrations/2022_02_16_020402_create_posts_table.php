<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_category_id');
            $table->string("title");
            $table->longText("description");
            $table->boolean("same_as_default")->default(1);
            $table->string("title_an")->nullable();
            $table->longText("description_an")->nullable();
            $table->longText("data_file")->nullable();
            $table->string("slug");
            $table->string("meta_title")->nullable();
            $table->string("meta_description")->nullable();
            $table->boolean("status");
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
        Schema::dropIfExists('posts');
    }
}
