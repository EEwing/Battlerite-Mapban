<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('jobs');
        Schema::table('map_ban_sessions', function(Blueprint $table) {
            $table->dropForeign('map_ban_sessions_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('team1Logo');
            $table->dropColumn('team2Logo');

            $table->boolean('team1Ready')->after('team1Name')->default(false);
            $table->boolean('team2Ready')->after('team2Name')->default(false);

            $table->string('manageToken')->after('id');
            $table->string('team1Token')->after('team1Name');
            $table->string('team2Token')->after('team2Name');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //TODO: Actually implement down
    }
}
