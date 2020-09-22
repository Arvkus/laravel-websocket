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
            $table->integer('id')->autoIncrement();
            $table->string('provider_name')->nullable();
            $table->string('name')->nullable();
            $table->string('provider_id')->nullable();
            $table->boolean('isAdmin')->nullable();
            $table->string('device_token')->nullable(); // Notifications
            $table->string('email')->nullable();
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->string('remember_token')->rememberToken()->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('banned')->default(0);
            $table->boolean('notifications')->default(1); // Notifications
            $table->string("user_ip")->nullable();
            $table->dateTime('last_visit')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
