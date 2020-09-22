<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id'); // vartotojo id
            $table->integer('zone_id')->nullable(); // zonos id
            $table->integer('location_id')->nullable(); // vietos id
            $table->string('text'); // tekstas
            $table->integer('parent_id')->nullable(); // tevas[NULL] ar vaikas
            $table->tinyInteger('type')->default(1); // 1 - teigiamas, 0 - neigiamas
            $table->tinyInteger('secret')->nullable(); // anonimiskas
            $table->boolean('hided')->default(false); // pasleptas true/false
            $table->integer('reported')->default(0); //pranestas (kiekis)
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
        Schema::drop('comments');
    }
}
