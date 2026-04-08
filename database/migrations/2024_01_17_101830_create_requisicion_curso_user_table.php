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
        Schema::create('requisicion_curso_user', function (Blueprint $table) {
            $table->foreignId('requisicion_curso_id')
                ->constrained('requisiciones_curso')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('rol', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicion_curso_user');
    }
};
