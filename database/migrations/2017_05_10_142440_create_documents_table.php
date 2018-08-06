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
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('nb_orig')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('finish', ['roulé', 'plié'])->default('roulé');
            $table->unsignedInteger('delivery_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
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
