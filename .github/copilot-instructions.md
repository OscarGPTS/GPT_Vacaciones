# RRHH Satech Energy - AI Coding Agent Instructions

## Project Overview
Laravel 10 + Livewire 3 Human Resources Management System for Satech Energy. Core features: employee management, vacation requests with multi-level approval workflow, job positions, CV management, and course requisitions.

## Critical Architecture Patterns

### 1. Vacation Approval Workflow (Core Business Logic)
**Multi-level approval chain with configurable approvers:**
```
User Request → Direct Manager → Direction → HR → Approved
```

**Key Models:**
- `ManagerApprover` - Overrides default manager (boss_id) per department
- `DirectionApprover` - Overrides default director (job_id=60) per department
- `RequestVacations` - Stores assigned approver IDs: `direct_manager_id`, `direction_approbation_id`

**CRITICAL RULE:** When creating/approving requests:
1. **Creation** (`VacacionesController::store`): Check `ManagerApprover::getManagerForDepartment($user->job->depto_id)` → assign to `direct_manager_id` (fallback to `boss_id`)
2. **Manager Approval** (`RequestController::approveRejectManager`): Check `DirectionApprover::getDirectionApproverForDepartment()` → assign to `direction_approbation_id` (fallback to job_id=60)
3. **Filtering**: ALWAYS filter by exact ID match (`WHERE direct_manager_id = auth()->id()`), NEVER by department or job_id
4. **Sidebar Counts** (`SidebarComposer.php`): Count only assigned requests (`WHERE direction_approbation_id = auth()->id()`)

**Why:** Ensures one person per approval level sees each request, respecting organizational overrides.

### 2. Livewire Component Patterns
**Pagination Strategy:**
- **Simple queries** (database-level): `WithPagination` trait + `->paginate($perPage)`
  - Example: `VacacionesRh::getRequestsProperty()`
- **Complex filtering** (manual): `LengthAwarePaginator` for in-memory collections
  - Example: `VacationReport::employeesData()` (needs full dataset for expired/expiring filters)

**File Uploads:**
- Images: `WithFilePond` (Spatie) for employee photos, profile images
- Excel: `FastExcel` with `OpenSpout` backend (NOT PhpSpreadsheet)
- PDFs: `Spatie\MediaLibrary` for document storage

**WireUI Integration:**
All Livewire components use `WireUi\Traits\Actions` for notifications:
```php
$this->notification()->success($title, $description);
$this->notification()->error($title, $description);
```

### 3. Excel Import/Export Architecture
**Service Pattern** (not controllers):
- `VacationImportService::importFromFile()` - Legacy service (ID-based)
- **NEW**: `VacationImport` (Livewire) - User-friendly import with manual matching
  - Uses employee full names instead of IDs
  - Simplified columns: `Nombre Completo`, `Fecha Ingreso`, `Fecha Aniversario`, `Dias Disponibles`, `Dias Disfrutados`
  - Auto-calculates: `status` (based on 15 months after ingreso), `dv=0`, `days_reserved=0`
  - 3-step process: Upload → Review/Match → Results
  - Unmatched users shown in separate table with dropdown assignment
- Uses `rap2hpoutre/fast-excel` package with OpenSpout (NOT PHPSpreadsheet)

**Key Features:**
```php
// Auto-identify users by name
$user = User::whereRaw("CONCAT(TRIM(last_name), ' ', TRIM(first_name)) = ?", [$nombre])
    ->where('active', 1)->first();

// Manual assignment for unmatched records
public function assignUser($recordIndex, $userId)
{
    // Moves record from unmatchedRecords to validRecords
}

// Auto-calculate status
$fechaLimite = Carbon::parse($fechaIngreso)->addMonths(15);
$status = Carbon::now()->greaterThan($fechaLimite) ? 'vencido' : 'actual';
```

### 4. View Composers for Shared Data
`app/View/Composers/SidebarComposer.php` provides notification counts:
- `$pendingManagerRequests` - Direct manager approval queue
- `$pendingDirectionRequests` - Direction approval queue  
- `$pendingRHRequests` - HR approval queue
- Registered in `AppServiceProvider::boot()` via `View::composer()`

### 5. Auto-Approval System (Scheduled)
**Service-based architecture** (NOT controllers):
- `AutoApprovalService::processAutoApprovals()` - Approves requests pending >5 days
- `php artisan vacations:auto-approve` - Command with `--dry-run` and `--stats` options
- Scheduled daily at 9:00 AM in `app/Console/Kernel.php`
- Manual trigger from Livewire: `VacacionesRh::processAutoApprovals()`

**Windows XAMPP:** Configure Task Scheduler to run `php artisan schedule:run` every minute.

## Development Environment

### Stack
- **Backend:** Laravel 10.48, PHP 8.1+
- **Frontend:** Livewire 3.4, Tailwind CSS 3.3, WireUI 1.18, Flowbite
- **Database:** MySQL (XAMPP on Windows)
- **Build:** Laravel Mix 6 (not Vite)

### Key Dependencies
```json
"livewire/livewire": "^3.4.2",
"wireui/wireui": "^1.18",
"spatie/laravel-permission": "^6.0",
"spatie/laravel-medialibrary": "^10.0",
"rap2hpoutre/fast-excel": "^5.5.0",
"barryvdh/laravel-dompdf": "^2.2"
```

### Build Commands
```bash
npm run dev          # Development build
npm run watch        # Watch mode
npm run production   # Production build (minified)
```

### Important: Use PowerShell syntax for multi-command operations (semicolon `;`, not `&&`)

## File Organization

### Livewire Components
- `app/Livewire/` - Component classes
- `resources/views/livewire/` - Component views
- **Naming:** PascalCase class → kebab-case view (e.g., `VacacionesRh` → `vacaciones-rh.blade.php`)

### Services Layer
Critical business logic lives in services, NOT controllers:
- `app/Services/VacationImportService.php` - Excel import/export
- `app/Services/AutoApprovalService.php` - Automated approvals

### Routes Organization
- `routes/web.php` - Public + auth routes, vacation module
- `routes/rrhh.php` - HR module (employees, positions)
- `routes/perfil.php` - User profile (CV, personal data)
- `routes/api.php` - API endpoints (minimal)

### Key Directories
```
app/
├── Console/Commands/     # Artisan commands (e.g., ProcessAutoApprovals)
├── Http/Controllers/
│   ├── Admin/           # Approver management
│   └── Vacaciones/      # Vacation controllers
├── Livewire/            # All Livewire components
├── Models/              # Eloquent models
├── Services/            # Business logic layer
├── View/Composers/      # View composers for shared data
└── Helpers/             # Global helper functions (autoloaded in composer.json)
```

## Common Patterns & Conventions

### Database Relationships
```php
// User has custom manager via ManagerApprover table
$user->job->depto_id → ManagerApprover::where('departamento_id') → direct_manager_id

// Request belongs to assigned approvers (NOT polymorphic)
RequestVacations::directManager() // BelongsTo User via direct_manager_id
RequestVacations::directionApprover() // BelongsTo User via direction_approbation_id
```

### Permission Gates
Uses `spatie/laravel-permission`:
```php
@can('ver modulo rrhh')     // View HR module
@can('edit colaborador')    // Edit employees
```

### Blade Component Libraries
- **WireUI:** `<x-input>`, `<x-select>`, `<x-button>` with Alpine.js
- **Custom:** Tailwind-styled components in `resources/views/components/`

### State Management (Vacation Requests)
Uses `asantibanez/laravel-eloquent-state-machines`:
```php
$requisicion->status()->transitionTo('en revisión por dirección general', ['motivo' => $reason]);
```

## Testing Approach

### Manual Test Scripts (Not PHPUnit)
Located in `tests/` directory:
- `test_vacation_import.php` - Validates import service
- `test_vacation_update.php` - Tests period updates
- `test_manager_approver_logic.php` - Verifies approval assignment

**Run with:** `php tests/test_manager_approver_logic.php`

### No Automated Test Suite
Project does not use PHPUnit. Testing is manual via test scripts and browser testing.

## Critical "Gotchas"

1. **Users don't have `departamento_id`** - Use `$user->job->depto_id` to get department
2. **Excel imports use FastExcel** - NOT PhpSpreadsheet (different API)
3. **Pagination reset** - Add `updated()` method in Livewire components to reset page on filter changes
4. **Approver tables have priority** - Always check `ManagerApprover`/`DirectionApprover` BEFORE using default boss_id/job_id
5. **Filter by exact ID** - Never filter approvals by department; use assigned `direct_manager_id`/`direction_approbation_id`
6. **Old requests may have wrong IDs** - Requests created before approver logic fix need data migration

## Documentation Files

- `docs/SISTEMA_AUTO_APROBACION.md` - Auto-approval system architecture
- `docs/SISTEMA_NOTIFICACIONES_VACACIONES.md` - Notification workflows
- `docs/VENCIMIENTO_PERIODOS_VACACIONES.md` - Period expiration logic
- `docs/IMPORTACION_MASIVA_VACACIONES.md` - Excel import specification

## Common Tasks

### Adding New Vacation Approval Level
1. Create approver model (e.g., `SupervisorApprover`) with `user_id`, `departamento_id`, `is_active`
2. Add static method: `getApproverForDepartment($departamentoId)`
3. Add migration for `requests` table: `{level}_approbation_id`, `{level}_approbation_status`
4. Update controller logic to assign approver ID on previous level approval
5. Create Livewire component filtered by: `WHERE {level}_approbation_id = auth()->id()`
6. Update `SidebarComposer` to count assigned requests
7. Add admin CRUD for approver management (see `Admin/DirectionApproversController.php`)

### Creating Excel Import Feature
**Pattern:** Livewire component with 3-step wizard (NOT service-based)

1. **Create Livewire Component** with step-based flow:
   - Step 1: File upload with template download
   - Step 2: Preview with validation + manual assignment
   - Step 3: Results display
   
2. **Use simplified Excel format** (user-friendly column names):
   - Headers in natural language (e.g., "Nombre Completo" not "user_id")
   - Date formats: Support `dd/mm/yyyy`, `dd-mm-yyyy`, `yyyy-mm-dd`
   - Auto-calculate technical fields when possible
   
3. **Implement parseDate() for flexible date handling**:
   ```php
   // Support multiple formats with regex detection
   if (preg_match('/^(\d{2})[\\/](\d{2})[\\/](\d{4})$/', $value)) {
       return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
   }
   ```

4. **Create preview with visual validation** (Step 2):
   - **Section 1**: Green block with table of valid records
   - **Section 2**: Yellow block with cards for unmatched records
   - Show ALL data fields for user validation
   - Include dropdown for manual assignment
   - Auto-move records when assigned (Livewire reactivity)

5. **Critical Validations to Implement**:
   - **Días disfrutados <= Días disponibles**: ALWAYS validate in both parseRow() and importRecord()
   - **Exact date matching**: Reject periods with similar dates (±7 days), force manual correction
   - **Case-insensitive name matching**: Support MAYÚSCULAS, minúsculas, inverted order
   - **Multiple date formats**: dd/mm/yyyy, dd-mm-yyyy, yyyy-mm-dd, Excel serial
   - **Show validation errors clearly**: Use error message format "Los días disfrutados (X) no pueden ser mayores a los días disponibles (Y)"
   
6. **Visual Design Guidelines**:
   - Use color-coded blocks (green for valid, yellow for pending)
   - Sticky table headers for scrollable content
   - Badges for status/numbers (Bootstrap classes)
   - Icons for visual guidance (fa icons)
   - Separate scrollable areas to avoid confusion
   
7. **Template generation** with user-friendly format:
   ```php
   FastExcel::data([
       ['Nombre Completo' => 'GARCÍA LÓPEZ JUAN', 
        'Fecha Ingreso' => '08/08/2024', ...]
   ])->export($path);
   ```

8. **Route and menu integration**:
   - Add route: `Route::get('/importar', Component::class)`
   - Add sidebar menu item with permission check
   - Remove old import functionality if exists

### Adding Sidebar Notification Badge
1. Update `app/View/Composers/SidebarComposer.php`
2. Query count with exact filters (avoid N+1 queries)
3. Pass variable to view via `$view->with(['badgeName' => $count])`
4. In sidebar blade: `@if(isset($badgeName) && $badgeName > 0) <span>{{ $badgeName }}</span> @endif`

---

**Last Updated:** Based on vacation approval refactor implementing configurable approvers (November 2025)
