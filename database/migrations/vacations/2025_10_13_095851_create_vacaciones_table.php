<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Conexión de destino para las tablas de vacaciones.
     */
    protected $connection = 'mysql_vacations';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mysql_vacations')->create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('created_by_user_id')->nullable()->index();
            $table->integer('reveal_id')->nullable();
            $table->string('type_request');
            $table->string('payment');
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->string('opcion')->nullable();
            $table->string('reason');
            $table->text('doc_permiso')->nullable(); 
            $table->unsignedBigInteger('direct_manager_id')->index();
            $table->unsignedBigInteger('direction_approbation_id')->nullable()->index();
            $table->string('direct_manager_status')->default('Pendiente');
            $table->string('human_resources_status')->default('Pendiente');
            $table->string('direction_approbation_status')->default('Pendiente')->nullable();
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });


        Schema::connection('mysql_vacations')->create('vacations_availables', function (Blueprint $table) {
            $table->id();
            //Año de antigüedad del empleado (1,2,3,4,...)
            $table->unsignedInteger('period');
            //Días disponibles acumulados (saldo base fijo del período)
            $table->decimal('days_availables', 5, 2)->nullable()->default(0);
            //Días acumulados diario
            $table->decimal('days_calculated', 8, 2)->nullable()->default(0);
            //Días disfrutados/tomados
            $table->integer('days_enjoyed')->default(0);
            //Días disfrutados antes de la fecha de aniversario
            $table->decimal('days_enjoyed_before_anniversary', 5, 2)->nullable()->default(0);
            //Días disfrutados después de la fecha de aniversario
            $table->decimal('days_enjoyed_after_anniversary', 5, 2)->nullable()->default(0);
            //Días reservados en solicitudes pendientes de aprobación
            $table->decimal('days_reserved', 5, 2)->default(0);
            //Fecha inicio del periodo
            $table->date('date_start')->nullable();
            //Fecha fin del periodo
            $table->date('date_end')->nullable();
            //Fecha de corte del periodo
            $table->date('cutoff_date')->nullable();
            //Marca si es registro del esquema antiguo
            $table->boolean('is_historical')->default(false);
            $table->enum('status', ['actual', 'vencido'])->default('actual');
            $table->unsignedBigInteger('users_id')->index();

            $table->timestamps();
            
            $table->index(['users_id', 'date_start', 'date_end']);
        });

        Schema::connection('mysql_vacations')->create('request_approved', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->unsignedBigInteger('users_id')->index();
            $table->integer('requests_id')->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_vacations')->create('request_rejected', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->unsignedBigInteger('users_id')->index();
            $table->integer('requests_id')->nullable();
            $table->timestamps();
        });
        
        Schema::connection('mysql_vacations')->create('vacation_per_years', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('days');
        });

        Schema::connection('mysql_vacations')->create('no_working_days', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('reason')->nullable();
        });

        Schema::connection('mysql_vacations')->create('direction_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boss_id')->index()
                ->comment('Usuario que puede aprobar como dirección');
            $table->unsignedBigInteger('employee_id')->index()
                ->comment('Empleado específico asignado a este aprobador de dirección');
            $table->unsignedBigInteger('departamento_id')->index()
                ->comment('Departamento del empleado (para filtros rápidos)');
            $table->boolean('is_active')->default(true)
                ->comment('Si el aprobador está activo');
            $table->timestamps();
            $table->unique(['employee_id', 'boss_id'], 'unique_employee_direction');
        });


        Schema::connection('mysql_vacations')->create('manager_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boss_id')->index()
                ->comment('Usuario que actúa como jefe directo');
            $table->unsignedBigInteger('employee_id')->index()
                ->comment('Empleado específico asignado a este jefe directo');
            $table->unsignedBigInteger('departamento_id')->index()
                ->comment('Departamento del empleado (para filtros rápidos)');
            $table->boolean('is_active')->default(true)
                ->comment('Si el jefe aprobador está activo');
            $table->timestamps();
            $table->unique(['employee_id', 'boss_id'], 'unique_employee_manager');
        });


        Schema::connection('mysql_vacations')->create('system_logs', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->enum('level', ['error', 'warning', 'info', 'debug'])->default('error');
            $table->string('type', 100)->index();
            $table->text('message');            
            $table->json('context')->nullable();
            $table->enum('status', ['pending', 'resolved', 'ignored'])->default('pending')->index();
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable()->index();
            $table->text('resolution_notes')->nullable();            
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index(['type', 'status']);
            $table->index('created_at');
        });

        Schema::connection('mysql_vacations')->create('delegation_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()
                ->comment('Usuario que tiene permiso de solicitar en representación');
            $table->boolean('is_active')->default(true)
                ->comment('Si el permiso está activo');
            $table->timestamps();
            $table->unique('user_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_vacations')->dropIfExists('delegation_permissions');
        Schema::connection('mysql_vacations')->dropIfExists('system_logs');
        Schema::connection('mysql_vacations')->dropIfExists('manager_approvers');
        Schema::connection('mysql_vacations')->dropIfExists('direction_approvers');
        Schema::connection('mysql_vacations')->dropIfExists('no_working_days');
        Schema::connection('mysql_vacations')->dropIfExists('vacation_per_years'); 
        Schema::connection('mysql_vacations')->dropIfExists('request_rejected');
        Schema::connection('mysql_vacations')->dropIfExists('request_approved');
        Schema::connection('mysql_vacations')->dropIfExists('vacations_availables');
        Schema::connection('mysql_vacations')->dropIfExists('requests');
    
    }
};
