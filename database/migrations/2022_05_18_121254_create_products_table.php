<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->text('slug');
            $table->longText('description');
            $table->longText('image')->nullable();
            $table->longText('alt')->nullable();
            $table->float('price')->nullable()->default(0);
            $table->float('qty')->nullable()->default(0);
            $table->integer('category_id')->nullable()->default(1);
            $table->integer('active')->default(1)->comment("0 not published, 1 published");
            $table->integer('sort')->default(500);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('canonical')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
