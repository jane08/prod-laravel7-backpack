<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumntsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('code')->nullable();
            $table->string('device')->nullable();
        });
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('twofactor')->nullable()->default(0); // 0 нет , 1 да
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('device');
        });
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('twofactor');
        });
    }
}
