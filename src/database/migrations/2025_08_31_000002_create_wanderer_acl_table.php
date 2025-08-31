<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('seat_wanderer_access_sync_instances',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('wanderer_url');
            $table->uuid('access_list_id');
            $table->string('access_list_token');

            $table->unique(['wanderer_url','access_list_id','access_list_token'],'seat_wanderer_access_sync_instances_wanderer_unique');
        });

        $entries = DB::table('seat_wanderer_access_sync_roles')
            ->select(['wanderer_url','access_list_id','access_list_token'])
            ->distinct()
            ->get();

        foreach ($entries as $entry) {
            DB::table('seat_wanderer_access_sync_instances')
                ->insert([
                    'wanderer_url' => $entry->wanderer_url,
                    'access_list_id' => $entry->access_list_id,
                    'access_list_token' => $entry->access_list_token
                ]);
        }

        Schema::table('seat_wanderer_access_sync_roles',function (Blueprint $table){
            $table->unsignedBigInteger('wanderer_instance_id');
        });

        $entries = DB::table('seat_wanderer_access_sync_roles')->get();
        foreach ($entries as $entry){
            $instance = DB::table('seat_wanderer_access_sync_instances')
                ->where('wanderer_url', $entry->wanderer_url)
                ->where('access_list_id', $entry->access_list_id)
                ->where('access_list_token', $entry->access_list_token)
                ->first();

            DB::table('seat_wanderer_access_sync_roles')
                ->where('id',$entry->id)
                ->update([
                    'wanderer_instance_id' => $instance->id,
                ]);
        }

        Schema::table('seat_wanderer_access_sync_roles',function (Blueprint $table){
            $table->dropColumn('wanderer_url');
            $table->dropColumn('access_list_id');
            $table->dropColumn('access_list_token');
            $table->foreign('wanderer_instance_id')->references('id')->on('seat_wanderer_access_sync_instances')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seat_wanderer_access_sync_roles',function (Blueprint $table){
            $table->dropForeign('seat_wanderer_access_sync_roles_wanderer_instance_id_foreign');
        });
        Schema::table('seat_wanderer_access_sync_roles',function (Blueprint $table){
            $table->dropColumn('wanderer_instance_id');
            $table->string('wanderer_url');
            $table->uuid('access_list_id');
            $table->string('access_list_token');
        });
        Schema::dropIfExists('seat_wanderer_access_sync_instances');
        DB::table('seat_wanderer_access_sync_roles')->truncate();
    }
};
