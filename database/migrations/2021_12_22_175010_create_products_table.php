<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('category');
            $table->text('detail');
            $table->text('amount');
            $table->integer('price');
            $table->integer('views')->default(0);
            $table->date('expiration');
            $table->date('date_1');
            $table->integer('discount_1');
            $table->date('date_2');
            $table->integer('discount_2');
            $table->date('date_3');
            $table->integer('discount_3');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
