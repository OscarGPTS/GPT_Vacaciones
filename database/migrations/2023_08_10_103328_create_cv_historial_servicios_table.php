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
        Schema::create('cv_historial_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->integer('year');
            $table->string('ubicacion');

            $table->string('cabezal')->nullable();
            $table->string('ramal')->nullable();
            $table->string('clase')->nullable();

            $table->string('servicio')->nullable();
            $table->string('alcance')->nullable();
            $table->string('mes',10)->nullable();

            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('cv_historial_servicios');
    }
};
