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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('author_id');
            $table->foreignId('category_id');
            $table->foreignId('city_id');
            $table->string('header');
            $table->string('img_1');
            $table->string('img_2')->nullable();
            $table->string('img_3')->nullable();
            $table->string('description');
            $table->string('phone_number');
            $table->integer('views');
            $table->integer('quantity');
            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
