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
            $table->enum('role', ['utilisateur', 'administrateur'])->default('utilisateur');
            $table->string('email')->unique();
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token')->nullable()->unique();
			$table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->boolean('contact_confirmed')->default(false);
            $table->boolean('company_confirmed')->default(false);
            $table->boolean('was_invited')->default(false);
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
