<?php

namespace App\Livewire\Puestos;

use App\Models\Job;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Departamento;

class PuestoComponent extends Component
{
    use Actions;
    public $modal = false;
    public Job $puesto;
    public $departamentos;
    protected $rules = [
        'puesto.name' => 'required|unique:App\Models\Job,name',
        'puesto.depto_id' => 'required',
        'puesto.responsabilidad' => 'nullable',
        'puesto.funciones' => 'nullable',
    ];
    public function mount()
    {
        $this->puesto = new Job();
        $this->departamentos = Departamento::all();
    }

    protected $messages = [
        'puesto.name.required' => 'El campo NOMBRE es obligatorio. Por favor, ingrese la información solicitada.',
        'puesto.depto_id.required' => 'El campo DEPARTAMENTO es obligatorio. Por favor, ingrese la información solicitada.',
    ];
    public function render()
    {
        return view('livewire.puestos.puesto-component');
    }
    public function updatedPuestoArea()
    {
        $this->puesto->departamento = '';
    }
    public function guardar()
    {
        $this->validate();
        $this->puesto->responsabilidad = [];
        $this->puesto->funciones = [];
        $this->puesto->save();
        $this->modal = false;
        return redirect()->route('puestos.show', $this->puesto);
    }
}
