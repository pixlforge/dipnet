<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 1024);
            $table->unsignedInteger('delivery_id');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries');
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
        Schema::dropIfExists('delivery_comments');
    }
}
