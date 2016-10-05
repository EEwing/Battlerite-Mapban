<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_bans', function (Blueprint $table) {
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('map_ban_session_id');
            $table->unsignedInteger('banned_by');

            $table->foreign('map_id')->references('id')->on('maps');
            $table->foreign('map_ban_session_id')->references('id')->on('map_ban_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_bans');
    }
}
