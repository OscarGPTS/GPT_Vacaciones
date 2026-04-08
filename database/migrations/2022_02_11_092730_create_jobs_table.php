<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('jobs', function (Blueprint $table) {
   $table->id();
   $table->string('name')->unique();
   $table->string('objetivo', 500)->nullable();
   $table->json('funciones')->nullable();
   $table->json('responsabilidad')->nullable();
   $table->string('clasificacion', 20)->nullable();
   $table->json('relaciones_internas')->nullable();
   $table->json('relaciones_externas')->nullable();
   $table->json('personal_cargo')->nullable();
   $table->json('plan_contingencia')->nullable();
   $table->json('desarrollo')->nullable();
   $table->json('ambiente')->nullable();
   $table->json('requisitos')->nullable();
   $table->string('responsabilidad_sgi', 500)->nullable();
   $table->foreignId('depto_id')->constrained('departamentos');
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
  Schema::dropIfExists('jobs');
 }
}
