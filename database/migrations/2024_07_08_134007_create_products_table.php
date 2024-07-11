<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('preview_img_uri');
            $table->string('material');
            $table->string('size');
            $table->decimal('price', 10, 2);
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
