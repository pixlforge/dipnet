<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('billing_contact_id')->references('id')->on('contacts');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_business_id_foreign');
            $table->dropForeign('orders_billing_contact_id_foreign');
            $table->dropForeign('orders_created_by_user_id_foreign');
        });
    }
}
