<?php

namespace App\Livewire\Empleados;

use App\Models\Job;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UploadExcelComponent extends Component
{
    use WithFileUploads;

    public $file, $usersDB;

    public function mount()
    {
        $this->usersDB = User::with(['job'])
            ->get();
    }

    public function render()
    {
        return view('livewire.empleados.upload-excel-component');
    }

    public function guardar()
    {
        $empleados = fastexcel()->import(Storage::path('empleados.xlsx'));


        $puestos = $empleados->map(function ($item) {
            $item = collect($item);
            return   $item->only(['ÁREA', 'DEPARTAMENTO', 'PUESTO ACTUAL']);
        });
        $puestos = $puestos->unique('PUESTO ACTUAL');

        dd($puestos->count());
        foreach($puestos as $puesto){
            Job::create([
                'name' => $puesto['PUESTO ACTUAL'],
                'departamento' => $puesto['DEPARTAMENTO'],
                'area' => $puesto['ÁREA'],
            ]);
        }
    }
}
