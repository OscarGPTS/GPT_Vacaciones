<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RazonesSocialesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
         $this->call(JobsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UsersPersonalDataTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(CvCertificacionesTableSeeder::class);
        $this->call(CvCursoCertificacionsTableSeeder::class);
        $this->call(CvCursoSoldaduraTableSeeder::class);
        
        // Catálogo de vacaciones según LFT México
        $this->call(VacationPerYearSeeder::class);
        $this->call(CvExperienciasTableSeeder::class);
        $this->call(CvHistorialServiciosTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(PendingTransitionsTableSeeder::class);
        $this->call(PersonalAccessTokensTableSeeder::class);
        $this->call(PuestoConocimientosTableSeeder::class);
        $this->call(RequisicionCursoUserTableSeeder::class);
        $this->call(RequisicionesCursoTableSeeder::class);
        $this->call(RequisicionesPersonalTableSeeder::class);
        $this->call(StateHistoriesTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(AuditsTableSeeder::class);
        $this->call(CheckDocumentosTableSeeder::class);
    }
}
