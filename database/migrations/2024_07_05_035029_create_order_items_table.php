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
        Schema::create('order_items', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id_order_item');
            $table->foreignId('id_order')->constrained('orders')->references('id_order')->onDelete('cascade');
            $table->foreignId('id_product')->constrained('products')->references('id_product')->onDelete('cascade');
            //quantity
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
