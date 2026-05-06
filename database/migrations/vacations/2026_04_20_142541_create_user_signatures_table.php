<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Conexión secundaria — base de datos de vacaciones/solicitudes.
     * Sin FK explícita para evitar dependencia entre bases de datos.
     */
    protected $connection = 'mysql_vacations';

    public function up(): void
    {
        Schema::connection('mysql_vacations')->create('user_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->comment('ID del usuario (sin FK cross-DB)');
            $table->string('signature_url')->comment('Ruta pública al archivo PNG de la firma');
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql_vacations')->dropIfExists('user_signatures');
    }
};
