<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('created_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_comments');
    }
}
