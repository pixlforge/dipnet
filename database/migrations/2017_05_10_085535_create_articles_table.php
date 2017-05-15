<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference', 45)->unique();
            $table->string('description_web', 45);
            $table->string('description_dip', 45);
            $table->tinyInteger('required_printing');
            $table->tinyInteger('public');
            $table->tinyInteger('consumable');
            $table->integer('price')->nullable();
            $table->integer('price_m2')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('extra_rate_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
