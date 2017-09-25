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
            $table->string('file_path');
            $table->string('mime_type');
            $table->integer('quantity');
            $table->enum('rolled_folded_flat', ['roulé', 'plié']);
            $table->integer('length');
            $table->integer('width');
            $table->integer('nb_orig');
            $table->tinyInteger('free');
            $table->unsignedInteger('format_id');
            $table->unsignedInteger('delivery_id')->nullable();
            $table->unsignedInteger('article_id');
            $table->timestamps();

            $table->foreign('format_id')->references('id')->on('formats');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('article_id')->references('id')->on('articles');
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
