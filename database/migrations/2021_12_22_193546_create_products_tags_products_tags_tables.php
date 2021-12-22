<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTagsProductsTagsTables extends Migration
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
            $table->string('name','50')->unique();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name','50')->unique();
            $table->timestamps();
        });

        Schema::create('products_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('tag_id');
            $table->primary(['product_id','tag_id']);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_tags', function (Blueprint $table){
            $table->dropForeign('products_tags_product_id_foreign');
            $table->dropForeign('products_tags_tag_id_foreign');

            $table->dropIfExists('product_id');
            $table->dropIfExists('tag_id');
        });

        Schema::dropIfExists('products_tags');
        Schema::dropIfExists('products');
        Schema::dropIfExists('tags');
    }
}
