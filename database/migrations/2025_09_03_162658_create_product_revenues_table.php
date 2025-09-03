<?php

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
        Schema::create('product_revenues', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->foreignId('seller_id')->constrained('users')->cascadeOnDelete(); 
            $t->unsignedBigInteger('units_sold')->default(0);
            $t->decimal('gross_revenue', 12, 2)->default(0);
            $t->timestamps();

            $t->unique('product_id');
            $t->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_revenues');
    }
};
