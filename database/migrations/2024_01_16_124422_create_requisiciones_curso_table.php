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
        Schema::create('requisiciones_curso', function (Blueprint $table) {
            $table->id();
           $table->string('nombre');
           $table->string('tipo_capacitacion');
           $table->text('justificacion');
           $table->text('motivo');
           $table->text('beneficio');
           $table->text('comentarios');
           $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisiciones_curso');
    }
};
