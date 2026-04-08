<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPersonalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_personal_data', function (Blueprint $table) {
            $table->id();
            $table->date('birthday')->nullable();
            $table->string('curp', 50)->nullable();
            $table->string('rfc', 50)->nullable();
            $table->string('nss', 50)->nullable();
            $table->string('personal_mail', 40)->nullable();
            $table->string('personal_phone', 20)->nullable();
            $table->json('estado_civil')->nullable();
            $table->json('estudios')->nullable();
            $table->json('hijo')->nullable();
            $table->json('contacto_emergencia')->nullable();
            $table->json('alergias')->nullable();
            $table->string('tipo_sangre')->nullable();
            $table->json('enfermedad')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('users_personal_data');
    }
}
