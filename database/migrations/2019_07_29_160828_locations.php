<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('zone_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('address');
            $table->integer('positive')->default(0);
            $table->integer('negative')->default(0);
            $table->decimal('lat',11,7)->nullable();
            $table->decimal('lng',11,7)->nullable();
            $table->boolean('show')->default(false);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations
     * @return void
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
