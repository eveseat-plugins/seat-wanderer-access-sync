<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_wanderer_access_sync_roles',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('role_id')->unsigned();
            $table->string('wanderer_url');
            $table->uuid('access_list_id');
            $table->string('access_list_token');

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seat_wanderer_access_sync_roles');
    }
};
