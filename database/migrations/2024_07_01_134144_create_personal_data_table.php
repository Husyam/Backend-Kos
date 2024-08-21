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
        Schema::create('personal_data', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id_personal_data');
            $table->string('name');
            //gender
            $table->string('gender');
            //Profession
            $table->string('profession');
            //contact
            $table->string('contact');
            // //date check in
            // $table->date('date_check_in');
            //id user by table users
            $table->foreignId('id_user')->constrained('users')->references('id_user')->onDelete('cascade');

            //is default
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_data');
    }
};
