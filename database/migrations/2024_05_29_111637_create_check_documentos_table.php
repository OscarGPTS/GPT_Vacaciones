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
        Schema::create('check_documentos', function (Blueprint $table) {
            $table->id();
            $table->boolean('acta_nacimiento')->default(false);
            $table->boolean('antecedentes_clinicos')->default(false);
            $table->boolean('carta_compromiso_codigo_etica')->default(false);
            $table->boolean('carta_oferta')->default(false);
            $table->boolean('cartas_recomendacion')->default(false);
            $table->boolean('certificado_medico')->default(false);
            $table->boolean('codigo_etica_conducta')->default(false);
            $table->boolean('comprobante_banco')->default(false);
            $table->boolean('comprobante_domicilio')->default(false);
            $table->boolean('comprobante_estudios')->default(false);
            $table->boolean('constancia_situacion_fiscal')->default(false);
            $table->boolean('cuestionario_anticorrupcion')->default(false);
            $table->boolean('curp')->default(false);
            $table->boolean('cv_solicitud_empleo')->default(false);
            $table->boolean('evalucion_entrevista')->default(false);
            $table->boolean('formato_aptitud')->default(false);
            $table->boolean('identificacion_oficial')->default(false);
            $table->boolean('kit_contratacion')->default(false);
            $table->boolean('numero_seguro_social')->default(false);
            $table->boolean('reglamento_interno_trabajo_firmado')->default(false);
            $table->json('opcionales')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_documentos');
    }
};
