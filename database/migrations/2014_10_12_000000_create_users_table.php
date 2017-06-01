<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
<<<<<<< HEAD
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('email')->unique();
            $table->tinyInteger('email_validated');
            $table->string('firstname', 45)->nullable();
            $table->string('lastname', 45)->nullable();
            $table->unsignedInteger('company_id')->nullable();
=======
            $table->string('role', 8);
            $table->tinyInteger('email_validated');
			$table->unsignedInteger('contact_id');
            $table->unsignedInteger('company_id');
>>>>>>> d9f7eea78b1ce5f12380119f9ec8dac8ca7baf4c
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
