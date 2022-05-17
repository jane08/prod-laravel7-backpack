<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTariff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('code')->nullable()->change();
            $table->integer('active')->default(1)->nullable()->change();

            $table->dropColumn('month');
            $table->dropColumn('month_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('code')->nullable()->change();
            $table->integer('active')->default(1)->nullable()->change();

            $table->string('month')->nullable();
            $table->string('month_text')->nullable();
        });
    }
}
