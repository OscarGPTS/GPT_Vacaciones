<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\RequestVacations;
use App\Services\VacationCalculatorService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VacationCalculatorServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected VacationCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Desactivar foreign key checks para pruebas
        Schema::disableForeignKeyConstraints();
        
        $this->service = new VacationCalculatorService();
    }

    protected function tearDown(): void
    {
        Schema::enableForeignKeyConstraints();
        parent::tearDown();
    }

    /**
     * Helper para crear un usuario sin validar foreign keys
     */
    protected function createTestUser($attributes = []): User
    {
        $defaults = [
            'id' => rand(1000, 9999),
            'uuid' => \Illuminate\Support\Str::uuid(),
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test' . rand(1000, 9999) . '@example.com',
            'phone' => '1234567890',
            'admission' => '2020-01-01',
            'active' => true,
            'business_name_id' => 1,
            'job_id' => 1,
        ];

        $data = array_merge($defaults, $attributes);
        
        // Crear directamente en la BD sin validaciones
        DB::table('users')->insert(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return User::find($data['id']);
    }

    /**
     * Test: Calcular días de vacaciones según antigüedad con esquema antiguo
     */
    public function test_get_days_for_seniority_old_scheme()
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('getDaysForSeniority');
        $method->setAccessible(true);

        $oldScheme = VacationCalculatorService::OLD_SCHEME_DAYS;

        // Año 1: 6 días
        $this->assertEquals(6, $method->invoke($this->service, 1, $oldScheme));
        
        // Año 2: 8 días
        $this->assertEquals(8, $method->invoke($this->service, 2, $oldScheme));
        
        // Año 3: 10 días
        $this->assertEquals(10, $method->invoke($this->service, 3, $oldScheme));
        
        // Año 4: 12 días
        $this->assertEquals(12, $method->invoke($this->service, 4, $oldScheme));
        
        // Año 5: 20 días (según rangos definidos)
        $this->assertEquals(20, $method->invoke($this->service, 5, $oldScheme));
        
        // Año 8: 22 días (6-10 años)
        $this->assertEquals(22, $method->invoke($this->service, 8, $oldScheme));
        
        // Año 12: 24 días (11-15 años)
        $this->assertEquals(24, $method->invoke($this->service, 12, $oldScheme));
        
        // Año 18: 26 días (16-20 años)
        $this->assertEquals(26, $method->invoke($this->service, 18, $oldScheme));
        
        // Año 23: 28 días (21-25 años)
        $this->assertEquals(28, $method->invoke($this->service, 23, $oldScheme));
        
        // Año 28: 30 días (26-30 años)
        $this->assertEquals(30, $method->invoke($this->service, 28, $oldScheme));
        
        // Año 33: 32 días (31-35 años)
        $this->assertEquals(32, $method->invoke($this->service, 33, $oldScheme));
        
        // Año 40: 32 días (máximo)
        $this->assertEquals(32, $method->invoke($this->service, 40, $oldScheme));
    }

    /**
     * Test: Calcular días de vacaciones según antigüedad con esquema actual
     */
    public function test_get_days_for_seniority_current_scheme()
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('getDaysForSeniority');
        $method->setAccessible(true);

        $currentScheme = VacationCalculatorService::CURRENT_SCHEME_DAYS;

        // Año 1: 12 días
        $this->assertEquals(12, $method->invoke($this->service, 1, $currentScheme));
        
        // Año 2: 14 días
        $this->assertEquals(14, $method->invoke($this->service, 2, $currentScheme));
        
        // Año 3: 16 días
        $this->assertEquals(16, $method->invoke($this->service, 3, $currentScheme));
        
        // Año 4: 18 días
        $this->assertEquals(18, $method->invoke($this->service, 4, $currentScheme));
        
        // Año 5: 20 días
        $this->assertEquals(20, $method->invoke($this->service, 5, $currentScheme));
        
        // Año 10: 22 días
        $this->assertEquals(22, $method->invoke($this->service, 10, $currentScheme));
        
        // Año 35: 32 días (máximo)
        $this->assertEquals(32, $method->invoke($this->service, 35, $currentScheme));
    }

    /**
     * Test: Cálculo de acumulación diaria en año normal
     */
    public function test_calculate_daily_accumulation_normal_year()
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('calculateDailyAccumulation');
        $method->setAccessible(true);

        // Caso 1: Un mes completo (30 días) de un año con 12 días anuales
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2024, 1, 30);
        $annualDays = 12;

        $result = $method->invoke($this->service, $startDate, $endDate, $annualDays);
        
        // (12 días * 30 días trabajados) / 366 (año bisiesto) = 0.98
        $this->assertEquals(0.98, $result);

        // Caso 2: 6 meses completos (aproximadamente 183 días)
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 6, 30);
        $annualDays = 12;

        $result = $method->invoke($this->service, $startDate, $endDate, $annualDays);
        
        // (12 días * 181 días) / 365 = 5.95
        $this->assertEquals(5.95, $result);

        // Caso 3: Año completo
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 12, 31);
        $annualDays = 12;

        $result = $method->invoke($this->service, $startDate, $endDate, $annualDays);
        
        // Debe ser exactamente 12 días
        $this->assertEquals(12.00, $result);
    }

    /**
     * Test: Cálculo de acumulación diaria en año bisiesto
     */
    public function test_calculate_daily_accumulation_leap_year()
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('calculateDailyAccumulation');
        $method->setAccessible(true);

        // Año bisiesto completo (366 días)
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2024, 12, 31);
        $annualDays = 12;

        $result = $method->invoke($this->service, $startDate, $endDate, $annualDays);
        
        // Debe ser exactamente 12 días
        $this->assertEquals(12.00, $result);

        // Medio año bisiesto (de enero 1 a junio 30 = 182 días)
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2024, 6, 30);
        $annualDays = 12;

        $result = $method->invoke($this->service, $startDate, $endDate, $annualDays);
        
        // (12 * 182) / 366 = 5.97
        $this->assertEquals(5.97, $result);
    }

    /**
     * Test: Generación de registros históricos para empleado con esquema antiguo
     */
    public function test_generate_historical_records_for_old_employee()
    {
        // Crear usuario con fecha de admisión antes de 2023
        $user = $this->createTestUser([
            'admission' => '2020-03-15',
        ]);

        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('generateHistoricalRecords');
        $method->setAccessible(true);

        $admissionDate = Carbon::parse('2020-03-15');
        $policyChangeDate = Carbon::parse(VacationCalculatorService::POLICY_CHANGE_DATE);

        $records = $method->invoke($this->service, $user, $admissionDate, $policyChangeDate);

        // Debe crear registros de 2020, 2021, 2022 (3 años)
        $this->assertCount(3, $records);

        // Verificar primer año (2020): 6 días
        $this->assertEquals(6, $records[0]->days_availables);
        $this->assertEquals('2020-03-15', $records[0]->date_start->format('Y-m-d'));
        $this->assertTrue($records[0]->is_historical);
        $this->assertEquals(6, $records[0]->days_enjoyed); // Marcado como tomado

        // Verificar segundo año (2021): 8 días
        $this->assertEquals(8, $records[1]->days_availables);
        $this->assertEquals('2021-03-15', $records[1]->date_start->format('Y-m-d'));
        
        // Verificar tercer año (2022): 10 días
        $this->assertEquals(10, $records[2]->days_availables);
        $this->assertEquals('2022-03-15', $records[2]->date_start->format('Y-m-d'));
    }

    /**
     * Test: No debe generar duplicados de registros históricos
     */
    public function test_generate_historical_records_no_duplicates()
    {
        $user = $this->createTestUser([
            'admission' => '2020-06-01',
        ]);

        // Crear un registro histórico existente
        VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 1,
            'days_availables' => 6,
            'dv' => 0,
            'days_enjoyed' => 6,
            'date_start' => '2020-06-01',
            'date_end' => '2021-05-31',
            'cutoff_date' => '2021-12-31',
            'is_historical' => true,
        ]);

        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('generateHistoricalRecords');
        $method->setAccessible(true);

        $admissionDate = Carbon::parse('2020-06-01');
        $policyChangeDate = Carbon::parse(VacationCalculatorService::POLICY_CHANGE_DATE);

        $records = $method->invoke($this->service, $user, $admissionDate, $policyChangeDate);

        // Solo debe crear 2 nuevos registros (2021 y 2022), no duplicar 2020
        $this->assertCount(2, $records);

        // Verificar que el total en BD es 3 (1 existente + 2 nuevos)
        $totalRecords = VacationsAvailable::where('users_id', $user->id)
            ->where('is_historical', true)
            ->count();
        
        $this->assertEquals(3, $totalRecords);
    }

    /**
     * Test: Calcular vacaciones para usuario nuevo (esquema actual)
     */
    public function test_calculate_vacations_for_new_employee()
    {
        // Usuario contratado en 2023 (usa esquema nuevo)
        $user = $this->createTestUser([
            'admission' => '2023-01-15',
        ]);

        // Mockeamos la fecha actual
        Carbon::setTestNow(Carbon::create(2025, 10, 28));

        $result = $this->service->calculateVacationsForUser($user);

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('current', $result['data']);
        $this->assertArrayNotHasKey('historical', $result['data']); // No debe tener históricos

        // Debe tener registros de 2023, 2024, 2025
        $this->assertCount(3, $result['data']['current']);

        // Verificar años y días
        // Año 1 (2023): 12 días
        $this->assertEquals(12, $result['data']['current'][0]->days_availables);
        
        // Año 2 (2024): 14 días
        $this->assertEquals(14, $result['data']['current'][1]->days_availables);
        
        // Año 3 (2025): 16 días (acumulados hasta hoy)
        $this->assertGreaterThan(0, $result['data']['current'][2]->days_availables);
        $this->assertLessThanOrEqual(16, $result['data']['current'][2]->days_availables);

        Carbon::setTestNow(); // Reset mock
    }

    /**
     * Test: Calcular vacaciones para usuario antiguo (con históricos y actual)
     */
    public function test_calculate_vacations_for_old_employee_with_historical()
    {
        $user = $this->createTestUser([
            'admission' => '2020-05-01',
        ]);

        Carbon::setTestNow(Carbon::create(2025, 10, 28));

        $result = $this->service->calculateVacationsForUser($user);

        $this->assertTrue($result['success']);
        
        // Debe tener tanto históricos como actuales
        $this->assertArrayHasKey('historical', $result['data']);
        $this->assertArrayHasKey('current', $result['data']);

        // Históricos: 2020, 2021, 2022 (3 años)
        $this->assertCount(3, $result['data']['historical']);

        // Actuales: 2023, 2024, 2025 (3 años)
        $this->assertCount(3, $result['data']['current']);

        Carbon::setTestNow();
    }

    /**
     * Test: Usuario sin fecha de admisión debe fallar
     */
    public function test_calculate_vacations_without_admission_date()
    {
        // Crear usuario con fecha valida pero modificar el modelo después
        $user = $this->createTestUser([
            'admission' => '2020-01-01',
        ]);
        
        // Modificar el atributo admission a null en memoria (no en BD)
        $user->admission = null;

        $result = $this->service->calculateVacationsForUser($user);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('no tiene fecha de ingreso', $result['message']);
    }

    /**
     * Test: Usuario con fecha de admisión futura debe fallar
     */
    public function test_calculate_vacations_with_future_admission_date()
    {
        $user = $this->createTestUser([
            'admission' => '2026-01-01', // Fecha futura
        ]);

        Carbon::setTestNow(Carbon::create(2025, 10, 28));

        $result = $this->service->calculateVacationsForUser($user);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('inválida', $result['message']);

        Carbon::setTestNow();
    }

    /**
     * Test: Obtener días disponibles totales para un usuario
     */
    public function test_get_available_days_for_user()
    {
        $user = $this->createTestUser([
            'admission' => '2023-01-01',
        ]);

        // Crear vacaciones disponibles
        VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 1,
            'days_availables' => 12.00,
            'dv' => 0,
            'days_enjoyed' => 5,
            'date_start' => '2023-01-01',
            'date_end' => '2023-12-31',
            'cutoff_date' => '2023-12-31',
            'is_historical' => false,
        ]);

        VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 2,
            'days_availables' => 14.00,
            'dv' => 2,
            'days_enjoyed' => 3,
            'date_start' => '2024-01-01',
            'date_end' => '2024-12-31',
            'cutoff_date' => '2024-12-31',
            'is_historical' => false,
        ]);

        $result = $this->service->getAvailableDaysForUser($user);

        // Total disponible: (12 + 0) + (14 + 2) = 28
        $this->assertEquals(28.00, $result['total_available']);

        // Total disfrutado: 5 + 3 = 8
        $this->assertEquals(8, $result['total_enjoyed']);

        // Total restante: 28 - 8 = 20
        $this->assertEquals(20.00, $result['total_remaining']);

        // Debe incluir 2 periodos
        $this->assertCount(2, $result['periods']);
    }

    /**
     * Test: Días disponibles solo cuenta registros no históricos
     */
    public function test_get_available_days_excludes_historical()
    {
        $user = $this->createTestUser([
            'admission' => '2020-01-01',
        ]);

        // Crear registro histórico
        VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 1,
            'days_availables' => 6.00,
            'dv' => 0,
            'days_enjoyed' => 6,
            'date_start' => '2020-01-01',
            'date_end' => '2020-12-31',
            'cutoff_date' => '2020-12-31',
            'is_historical' => true,
        ]);

        // Crear registro actual
        VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 1,
            'days_availables' => 12.00,
            'dv' => 0,
            'days_enjoyed' => 0,
            'date_start' => '2023-01-01',
            'date_end' => '2023-12-31',
            'cutoff_date' => '2023-12-31',
            'is_historical' => false,
        ]);

        $result = $this->service->getAvailableDaysForUser($user);

        // Solo debe contar el registro no histórico (12 días)
        $this->assertEquals(12.00, $result['total_available']);
        $this->assertCount(1, $result['periods']);
    }

    /**
     * Test: Acumulación diaria para diferentes cantidades de días anuales
     */
    public function test_daily_accumulation_with_different_annual_days()
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('calculateDailyAccumulation');
        $method->setAccessible(true);

        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 3, 31); // 90 días

        // Con 12 días anuales
        $result = $method->invoke($this->service, $startDate, $endDate, 12);
        $expected = (12 * 90) / 365;
        $this->assertEquals(round($expected, 2), $result);

        // Con 20 días anuales
        $result = $method->invoke($this->service, $startDate, $endDate, 20);
        $expected = (20 * 90) / 365;
        $this->assertEquals(round($expected, 2), $result);

        // Con 32 días anuales (máximo)
        $result = $method->invoke($this->service, $startDate, $endDate, 32);
        $expected = (32 * 90) / 365;
        $this->assertEquals(round($expected, 2), $result);
    }

    /**
     * Test: Verificar que calculateCurrentScheme actualiza días acumulados para periodo actual
     */
    public function test_calculate_current_scheme_updates_accumulated_days()
    {
        $user = $this->createTestUser([
            'admission' => '2024-01-01',
        ]);

        // Crear registro existente para el año actual
        $existing = VacationsAvailable::create([
            'users_id' => $user->id,
            'period' => 1,
            'days_availables' => 5.00, // Días viejos
            'dv' => 0,
            'days_enjoyed' => 0,
            'date_start' => '2024-01-01',
            'date_end' => '2024-12-31',
            'cutoff_date' => '2024-12-31',
            'is_historical' => false,
        ]);

        Carbon::setTestNow(Carbon::create(2024, 7, 1)); // Mitad de año

        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('calculateCurrentScheme');
        $method->setAccessible(true);

        $admissionDate = Carbon::parse('2024-01-01');
        $today = Carbon::today();

        $records = $method->invoke(
            $this->service, 
            $user, 
            $admissionDate, 
            $today, 
            false, 
            Carbon::parse(VacationCalculatorService::POLICY_CHANGE_DATE)
        );

        // Debe actualizar el registro existente con días acumulados hasta hoy
        $updated = VacationsAvailable::find($existing->id);
        
        // A mitad de año debe tener aproximadamente 6 días acumulados (de 12 anuales)
        $this->assertGreaterThan(5.00, $updated->days_availables);
        $this->assertLessThanOrEqual(7.00, $updated->days_availables);

        Carbon::setTestNow();
    }

    /**
     * Test: Verificar periodo correcto según años de antigüedad
     */
    public function test_period_assignment_by_seniority()
    {
        $user = $this->createTestUser([
            'admission' => '2022-03-15',
        ]);

        Carbon::setTestNow(Carbon::create(2025, 10, 28));

        $result = $this->service->calculateVacationsForUser($user);

        $this->assertTrue($result['success']);

        // El servicio crea registros solo cuando se cumple al menos 1 año
        // Admisión: 2022-03-15
        // Año 1: del 2022-03-15 al 2023-03-14 (periodo 1) -> primer registro: 2023-03-15
        // Año 2: del 2023-03-15 al 2024-03-14 (periodo 2) -> segundo registro: 2024-03-15
        // Año 3: del 2024-03-15 al 2025-03-14 (periodo 3) -> tercer registro: 2025-03-15
        
        $this->assertCount(3, $result['data']['current']);
        
        // Primer registro (2023): año 2 de antigüedad, periodo 2
        $this->assertEquals(2, $result['data']['current'][0]->period);

        // Segundo registro (2024): año 3 de antigüedad, periodo 3
        $this->assertEquals(3, $result['data']['current'][1]->period);

        // Tercer registro (2025): año 4 de antigüedad, periodo 3 (máximo es 3)
        $this->assertEquals(3, $result['data']['current'][2]->period);

        Carbon::setTestNow();
    }
}
