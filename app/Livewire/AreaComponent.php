<?php

namespace App\Livewire;

use App\Models\Area;
use Livewire\Component;
use WireUi\Traits\Actions;


class AreaComponent extends Component
{
    use Actions;
    public $area;
    public $areas, $modal = false;

    protected $rules = [
        'area.name' => 'required'
    ];
    protected $messages = [
        'area.name.required' => 'El nombre es obligatorio'
    ];
    public function mount()
    {
        $this->areas = Area::all();
        $this->area['name'] = '';
    }
    public function render()
    {
        return view('livewire.area-component');
    }
    public function crear()
    {
        $this->modal = true;
        $this->area = new Area();
    }
    public function editar($id)
    {
        $this->modal = true;
        $this->area = Area::find($id);
    }

    public function guardar()
    {
        $this->validate();
        try {
            $this->area->save();
            $this->modal = false;
            $this->mount();
            $this->notification()->success(
                $title = 'Area',
                $description = 'Area guardada con exito'
            );

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Area',
                $description = 'Ocurrio un error al guardar la area'
            );
        }

    }
}
