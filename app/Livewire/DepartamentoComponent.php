<?php

namespace App\Livewire;

use App\Models\Area;
use Livewire\Component;
use App\Models\Departamento;

class DepartamentoComponent extends Component
{
    public Departamento $depto;
    public $departamentos, $modal = false, $areas;

    protected $rules = [
        'depto.name' => 'required',
        'depto.area_id' => 'required'
    ];
    public function mount()
    {
        $this->departamentos = Departamento::with('area')->get();
        $this->areas = Area::all();
        $this->depto = new Departamento();
    }
    public function render()
    {
        return view('livewire.departamento-component');
    }
    public function crear()
    {
        $this->modal = true;
        $this->depto = new Departamento();
    }
    public function editar($id)
    {
        $this->modal = true;
        $this->depto = Departamento::find($id);
    }

    public function guardar()
    {
        $this->validate();
        $this->depto->save();
        $this->modal = false;
        $this->mount();
    }
}
