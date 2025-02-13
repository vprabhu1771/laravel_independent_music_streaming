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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->unsignedBigInteger('genre_id');

            $table->unsignedBigInteger('brand_id');
            
            $table->string('image_path')->default('no_image_available.jpg')->nullable();
            
            $table->string('song_path')->default('no_image_available.jpg')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
