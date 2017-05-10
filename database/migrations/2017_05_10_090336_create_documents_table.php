<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('file_path', 1024);
            $table->string('mime_type', 45);
            $table->integer('quantity');
            $table->string('rolled_folded_flat', 8);
            $table->integer('length');
            $table->integer('width');
            $table->integer('nb_orig');
            $table->tinyInteger('free');
            $table->integer('format_id')->unsigned();
            $table->integer('delivery_id')->unsigned();
            $table->integer('article_id')->unsigned();
            $table->integer('option_article_id')->unsigned();
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
        Schema::dropIfExists('documents');
    }
}
