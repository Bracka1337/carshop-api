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
            $table->integer('diameter');
            $table->double('width');
            $table->double('et');
            $table->double('cb');
            $table->integer('bolt');
            $table->double('bolt_diameter');
            $table->string('type');
            $table->double('price', 10, 2);
            $table->foreignId('brand_id')->constrained('brands');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
