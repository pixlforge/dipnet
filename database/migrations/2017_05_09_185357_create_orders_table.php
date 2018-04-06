<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference', 45)->unique()->index();
            $table->enum('status', ['incomplète', 'traitée', 'envoyée'])->default('incomplète');
            $table->unsignedInteger('business_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('manager_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manager_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
