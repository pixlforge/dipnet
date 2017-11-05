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
            $table->string('filename')->index();
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->integer('quantity')->nullable();
            $table->enum('finish', ['roulé', 'plié']);
            $table->unsignedInteger('format_id')->nullable();
            $table->unsignedInteger('delivery_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('format_id')->references('id')->on('formats')->onDelete('set null');
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('set null');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('set null');
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
