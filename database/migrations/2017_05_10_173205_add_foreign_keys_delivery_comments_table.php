<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysDeliveryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_comments', function (Blueprint $table) {
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_comments', function (Blueprint $table) {
            $table->dropForeign('delivery_comments_delivery_id_foreign');
            $table->dropForeign('delivery_comments_user_id_foreign');
        });
    }
}
