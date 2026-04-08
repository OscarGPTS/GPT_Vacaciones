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
        Schema::create('cv_curso_soldadura', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('proceso',80);
            $table->string('wps')->nullable();
            $table->string('desde',20)->nullable();
            $table->string('hasta',20)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_curso_soldadura');
    }
};
