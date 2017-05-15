<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('zip', 16)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('phone_number', 45)->nullable();
            $table->string('fax', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->integer('discount')->nullable();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('contacts');
    }
}
