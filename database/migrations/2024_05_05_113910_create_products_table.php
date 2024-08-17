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
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id_product');
            $table->foreignId('category_id')->constrained('categories')->references('id_category')->onDelete('cascade');
            $table->string('name');
            //name owner
            $table->string('name_owner');
            //category gender
            $table->string('category_gender');
            //no hp
            $table->string('no_kontak');
            //price
            $table->integer('price');
            //description
            $table->text('description')->nullable();
            //stock
            $table->integer('stock');
            //address
            $table->string('address');
            //create longitude latitude

            // $table->decimal('latitude', 10, 8);
            // $table->decimal('longitude', 11, 8);
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            //image
            $table->string('image')->nullable();
            //isavailable
            $table->boolean('is_available')->default(true);
            $table->string('fasilitas')->nullable();
            $table->timestamps();
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
