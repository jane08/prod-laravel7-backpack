<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {

            $table->string('name')->nullable()->change();
            $table->longText('image')->nullable()->change();
            $table->string('status')->default("moderation")->comment("moderation, published, canceled");
            $table->integer('rating')->nullable()->default(0);
            $table->integer('user_id')->nullable();
            $table->string('special_word')->nullable();
            $table->integer('main_page')->nullable()->default(0);
            $table->integer('course_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('rating');
            $table->dropColumn('user_id');
            $table->dropColumn('special_word');
            $table->dropColumn('main_page');
            $table->dropColumn('course_id');
        });
    }
}
