<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        Schema::table('benefits', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });

      

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        Schema::table('benefits', function (Blueprint $table) {
            $table->dropColumn('alt');
        });

       

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('alt');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('alt');
        });
    }
}
