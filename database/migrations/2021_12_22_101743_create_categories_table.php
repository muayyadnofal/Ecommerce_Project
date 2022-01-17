<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \App\Models\Category::create(["name" => "Food",]);
        \App\Models\Category::create(["name" => "Technology",]);
        \App\Models\Category::create(["name" => "Phones",]);
        \App\Models\Category::create(["name" => "Jeans",]);
        \App\Models\Category::create(["name" => "Dresses",]);
        \App\Models\Category::create(["name" => "Shirt",]);
        \App\Models\Category::create(["name" => "Accessory",]);
        \App\Models\Category::create(["name" => "Electronics",]);
        \App\Models\Category::create(["name" => "Laptop",]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
