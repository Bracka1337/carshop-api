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
            $table->string('diameter');
            $table->string('width');
            $table->string('et');
            $table->string('cb');
            $table->string('bolt');
            $table->string('bolt_diameter');
            $table->string('type');
            $table->decimal('price', 10, 2);
            $table->foreignId('brand_id')->constrained('brands');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
