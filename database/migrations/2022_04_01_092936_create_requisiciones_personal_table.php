<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones_personal', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_personal', 50);
            $table->string('motivo', 50);
            $table->string('horario', 50);
            $table->tinyInteger('personas_requeridas');
            $table->string('grado_escolar');
            $table->tinyInteger('experiencia_years');
            $table->tinyInteger('trabajo_campo')->nullable();
            $table->tinyInteger('trato_clientes')->nullable();
            $table->tinyInteger('manejo_personal')->nullable();
            $table->tinyInteger('licencia_conducir')->nullable();
            $table->string('licencia_tipo', 30)->nullable();
            $table->json('conocimientos')->nullable();
            $table->json('competencias')->nullable();
            $table->json('actividades')->nullable();
            $table->string('status');

            $table->foreignId('puesto_solicitado')
                ->nullable()
                ->constrained('jobs');
            $table->string('puesto_nuevo', 100)->nullable();

            $table->foreignId('solicitante_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisiciones_personal');
    }
};
