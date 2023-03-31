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
        Schema::create('userdata', function (Blueprint $table) {
            $table->id();
            $table->string('userEmail');
            $table->integer('activity');
            $table->integer('age');
            $table->integer('calPerDayHold');
            $table->integer('calPerDayLose');
            $table->string('dateOfBirth');
            $table->integer('gender');
            $table->integer('height');
            $table->string('imt');
            $table->string('imtStatus');
            $table->boolean('isFilled');
            $table->integer('medicalCondition');
            $table->json('recommendation');
            $table->integer('weight');
            $table->string('profileUrl');
            // TODO: has to be validated beforehand
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userdata');
    }
};
