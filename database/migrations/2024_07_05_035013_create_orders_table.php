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
        Schema::create('orders', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id_order');
            $table->foreignId('id_user')->constrained('users')->references('id_user')->onDelete('cascade');
            //personal data
            $table->foreignId('id_personal_data')->constrained('personal_data')->references('id_personal_data')->onDelete('cascade');
            //sub total
            $table->integer('sub_total');
            //shipping cost
            $table->integer('shipping_cost');
            //total
            $table->integer('total_cost');
            //status
            $table->enum('status', ['pending', 'paid', 'failed','expired' ,'canceled']);
            //payment
            $table->enum('payment_method', ['bank_transfer', 'e-wallet']);
            //payment va name
            $table->string('payment_va_name')->nullable();
            //payment va number
            $table->string('payment_va_number')->nullable();
            //payment ewallet
            $table->string('payment_ewallet')->nullable();
            //transaction number
            $table->string('transaction_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
