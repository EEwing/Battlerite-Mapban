<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStageToMapBanSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_ban_sessions', function (Blueprint $table) {
            $table->unsignedInteger('stage')->default(0)->after('team2Ready');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_ban_sessions', function (Blueprint $table) {
            $table->dropColumn('stage');
        });
    }
}
