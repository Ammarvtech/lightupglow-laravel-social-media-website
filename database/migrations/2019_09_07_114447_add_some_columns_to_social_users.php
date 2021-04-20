<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToSocialUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_users', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('name');
            $table->bigInteger('access_token')->default(NULL);
            $table->string('profile_url');
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_users', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('name');
            $table->dropColumn('access_token');
            $table->dropColumn('profile_url');
            $table->dropColumn('username');
        });
    }
}
