<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VacationPerYear;

class VacationPerYearSeeder extends Seeder
{
    /**
     * Seed the vacation_per_years table with Mexican Labor Law (LFT) standards.
     * 
     * Ley Federal del Trabajo - Artículo 76:
     * - Los trabajadores que tengan más de un año de servicios disfrutarán
     *   de un período anual de vacaciones pagadas
     * - Nunca podrá ser inferior a doce días laborables
     * - Aumentará en dos días laborables, hasta llegar a veinte
     * - Por cada año subsecuente de servicios
     * - Después del quinto año, el período de vacaciones aumentará
     *   en dos días por cada cinco años de servicios
     */
    public function run(): void
    {
        $vacationScheme = [
            // Años 1-5: Incremento anual de 2 días (base 12)
            1 => 12,
            2 => 14,
            3 => 16,
            4 => 18,
            5 => 20,
            
            // Años 6-10: +2 días (se mantiene en 22)
            6 => 22,
            7 => 22,
            8 => 22,
            9 => 22,
            10 => 22,
            
            // Años 11-15: +2 días (incremento a 24)
            11 => 24,
            12 => 24,
            13 => 24,
            14 => 24,
            15 => 24,
            
            // Años 16-20: +2 días (incremento a 26)
            16 => 26,
            17 => 26,
            18 => 26,
            19 => 26,
            20 => 26,
            
            // Años 21-25: +2 días (incremento a 28)
            21 => 28,
            22 => 28,
            23 => 28,
            24 => 28,
            25 => 28,
            
            // Años 26-30: +2 días (incremento a 30)
            26 => 30,
            27 => 30,
            28 => 30,
            29 => 30,
            30 => 30,
            
            // Años 31-35: +2 días (incremento a 32, máximo legal común)
            31 => 32,
            32 => 32,
            33 => 32,
            34 => 32,
            35 => 32,
            
            // Años 36+: Se mantiene en 32 (políticas empresariales pueden variar)
            36 => 32,
            37 => 32,
            38 => 32,
            39 => 32,
            40 => 32,
        ];

        foreach ($vacationScheme as $year => $days) {
            VacationPerYear::updateOrCreate(
                ['year' => $year],
                ['days' => $days]
            );
        }

        $this->command->info('✅ Catálogo de vacaciones (LFT México) creado exitosamente.');
        $this->command->info('   → Años 1-5: 12-20 días (incremento anual)');
        $this->command->info('   → Años 6+: +2 días cada 5 años');
        $this->command->info('   → Máximo: 32 días de vacaciones');
    }
}
