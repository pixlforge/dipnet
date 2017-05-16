<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('format_id')->references('id')->on('formats');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('main_article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_format_id_foreign');
            $table->dropForeign('documents_delivery_id_foreign');
            $table->dropForeign('documents_main_article_id_foreign');
        });
    }
}
