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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->json('ctgList');
            $table->string('desc');
            $table->string('est');
            $table->string('img');
            $table->string('title');
            $table->string('totalEst');
            $table->string('vid');
            $table->json('workoutEsts');
            $table->json('workoutLists');
            $table->string('workoutId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
