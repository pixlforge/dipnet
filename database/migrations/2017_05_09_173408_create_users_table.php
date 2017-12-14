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
            $table->string('username')->unique()->index();
            $table->string('password');
            $table->enum('role', ['utilisateur', 'administrateur'])->default('utilisateur');
            $table->string('email')->unique();
            $table->unsignedInteger('company_id')->nullable();
            $table->boolean('is_solo')->default(false);
            $table->boolean('email_confirmed')->default(false);
            $table->boolean('contact_confirmed')->default(false);
            $table->boolean('company_confirmed')->default(false);
            $table->string('confirmation_token')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
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
