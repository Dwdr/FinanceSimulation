<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditsToSysUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_user_profiles', function (Blueprint $table) {
            
        });
    }

    /**
     * Reverse the migrations.a
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_user_profiles', function (Blueprint $table) {
            //
        });
    }
}
