<?php

namespace App\Livewire;

use App\Models\RequestVacations;
use App\Models\Departamento;
use Livewire\Component;
use Livewire\Attributes\Computed;

class VacationCalendar extends Component
{
    public $departmentFilter = '';
    
    protected $queryString = [
        'departmentFilter' => ['except' => '']
    ];

    public function mount()
    {
        // Verificar permisos de RH
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    #[Computed]
    public function departments()
    {
        return Departamento::orderBy('name')->get();
    }

    /**
     * Obtiene los eventos del calendario (vacaciones aprobadas)
     */
    public function getCalendarEvents()
    {
        $query = RequestVacations::with(['user.job.departamento', 'requestDays'])
            ->where('type_request', 'Vacaciones')
            ->where('human_resources_status', 'Aprobada');
        
        // Aplicar filtro por departamento si está activo
        if ($this->departmentFilter) {
            $query->whereHas('user.job.departamento', function($q) {
                $q->where('id', $this->departmentFilter);
            });
        }
        
        $vacations = $query->get();
        
        $events = [];
        
        foreach ($vacations as $vacation) {
            if ($vacation->user && $vacation->requestDays->count() > 0) {
                $userName = $vacation->user->first_name . ' ' . $vacation->user->last_name;
                $department = $vacation->user->job && $vacation->user->job->departamento 
                    ? $vacation->user->job->departamento->name 
                    : 'Sin departamento';
                
                // Crear un evento por cada día aprobado
                foreach ($vacation->requestDays as $day) {
                    $events[] = [
                        'id' => $vacation->id . '-' . $day->id,
                        'title' => $userName,
                        'start' => $day->start,
                        'end' => $day->start, // Eventos de un solo día
                        'allDay' => true,
                        'backgroundColor' => $this->getColorByDepartment($department),
                        'borderColor' => $this->getColorByDepartment($department),
                        'extendedProps' => [
                            'userName' => $userName,
                            'department' => $department,
                            'requestId' => $vacation->id
                        ]
                    ];
                }
            }
        }
        
        return $events;
    }

    /**
     * Asigna un color según el departamento
     */
    private function getColorByDepartment($department)
    {
        $colors = [
            'Sistemas' => '#3788d8',
            'Recursos Humanos' => '#e74c3c',
            'Operaciones' => '#2ecc71',
            'Administración' => '#f39c12',
            'Dirección' => '#9b59b6',
            'Ventas' => '#1abc9c',
            'Compras' => '#e67e22',
            'Almacén' => '#34495e',
            'Mantenimiento' => '#95a5a6',
        ];
        
        return $colors[$department] ?? '#3498db'; // Color por defecto
    }

    public function render()
    {
        return view('livewire.vacation-calendar');
    }
}
