-- ============================================
-- SCRIPT: Creación de vistas cross-database
-- Propósito: Permitir relaciones entre rh y rh_vacations
-- ============================================

-- IMPORTANTE: Ejecutar este script si las vistas se pierden
-- (por ejemplo, después de php artisan migrate:fresh)

-- ============================================
-- PARTE 1: Vistas en BD principal (rh)
-- Propósito: Permitir que User (en rh) pueda hacer whereHas('requestVacations')
-- ============================================

USE rh;

-- Eliminar vistas si existen (para recrear)
DROP VIEW IF EXISTS requests;
DROP VIEW IF EXISTS vacations_availables;
DROP VIEW IF EXISTS request_approved;
DROP VIEW IF EXISTS request_rejected;
DROP VIEW IF EXISTS vacation_per_years;
DROP VIEW IF EXISTS no_working_days;
DROP VIEW IF EXISTS direction_approvers;
DROP VIEW IF EXISTS manager_approvers;
DROP VIEW IF EXISTS system_logs;

-- Crear vistas que apuntan a rh_vacations
CREATE VIEW requests AS SELECT * FROM rh_vacations.requests;
CREATE VIEW vacations_availables AS SELECT * FROM rh_vacations.vacations_availables;
CREATE VIEW request_approved AS SELECT * FROM rh_vacations.request_approved;
CREATE VIEW request_rejected AS SELECT * FROM rh_vacations.request_rejected;
CREATE VIEW vacation_per_years AS SELECT * FROM rh_vacations.vacation_per_years;
CREATE VIEW no_working_days AS SELECT * FROM rh_vacations.no_working_days;
CREATE VIEW direction_approvers AS SELECT * FROM rh_vacations.direction_approvers;
CREATE VIEW manager_approvers AS SELECT * FROM rh_vacations.manager_approvers;
CREATE VIEW system_logs AS SELECT * FROM rh_vacations.system_logs;

SELECT 'PARTE 1 COMPLETADA: 9 vistas creadas en BD rh' AS status;

-- ============================================
-- PARTE 2: Vistas en BD vacaciones (rh_vacations)
-- Propósito: Permitir que RequestVacations pueda hacer whereHas('user.job.departamento')
-- ============================================

USE rh_vacations;

-- Eliminar vistas si existen (para recrear)
DROP VIEW IF EXISTS users;
DROP VIEW IF EXISTS jobs;
DROP VIEW IF EXISTS departamentos;

-- Crear vistas que apuntan a rh
CREATE VIEW users AS SELECT * FROM rh.users;
CREATE VIEW jobs AS SELECT * FROM rh.jobs;
CREATE VIEW departamentos AS SELECT * FROM rh.departamentos;

SELECT 'PARTE 2 COMPLETADA: 3 vistas creadas en BD rh_vacations' AS status;

-- ============================================
-- VERIFICACIÓN
-- ============================================

-- Verificar vistas en rh
SELECT 'Vistas en BD rh:' AS info;
SELECT TABLE_NAME, TABLE_TYPE 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'rh' 
AND TABLE_NAME IN ('requests','vacations_availables','request_approved','request_rejected',
                   'vacation_per_years','no_working_days','direction_approvers',
                   'manager_approvers','system_logs')
ORDER BY TABLE_NAME;

-- Verificar vistas en rh_vacations
SELECT 'Vistas en BD rh_vacations:' AS info;
SELECT TABLE_NAME, TABLE_TYPE 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'rh_vacations' 
AND TABLE_NAME IN ('users','jobs','departamentos')
ORDER BY TABLE_NAME;

-- ============================================
-- FINALIZADO
-- ============================================
SELECT '✓ Script completado - Todas las vistas cross-database creadas' AS resultado;
