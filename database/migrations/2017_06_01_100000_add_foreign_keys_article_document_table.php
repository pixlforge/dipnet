<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysArticleDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_document', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents');
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
        Schema::table('article_document', function (Blueprint $table) {
            $table->dropForeign('article_document_document_id_foreign');
            $table->dropForeign('article_document_article_id_foreign');
        });
    }
}
