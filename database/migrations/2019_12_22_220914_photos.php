<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("photos",function (Blueprint $table)
        {
            $table->integer("id")->autoIncrement();
            $table->integer("user_id");
            $table->integer("location_id")->nullable();
            $table->integer("comment_id")->nullable();
            $table->integer("zone_id")->nullable();
            $table->string("image_url");
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
        Schema::dropIfExists("photos");
    }
}
