<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_vacations';

    public function up(): void
    {
        Schema::connection('mysql_vacations')->create('custom_orgcharts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('description', 255)->nullable();
            // nodes: [{"id": user_id, "pid": parent_user_id|null, "label": "Rol"}]
            $table->json('nodes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql_vacations')->dropIfExists('custom_orgcharts');
    }
};
