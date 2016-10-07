<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapBanSessionsWithStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_ban_sessions', function (Blueprint $table) {
            $table->unsignedInteger('chosen_map')->nullable();
            $table->integer('current_team')->default(1);

            $table->foreign('chosen_map')->references('id')->on('maps');
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
            $table->dropForeign(['chosen_map']);

            $table->dropColumn('chosen_map');
            $table->dropColumn('current_team');
        });
    }
}
