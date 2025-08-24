<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $t->string('product_photo_path');
            $t->string('title');
            $t->enum('type', Product::$type);
            $t->enum('genre', Product::$genres);
            $t->string('duration');
            $t->string('company');
            $t->enum('platform', Product::$platforms);
            $t->decimal('price', 10, 2);
            $t->date('released_date');
            $t->decimal('size', 5, 2);
            $t->integer('age_rating');
            $t->text('description');
            $t->timestamps();

            $t->index(['platform', 'genre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
