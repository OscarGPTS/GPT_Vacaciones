<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\Job;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\JobDescription;
use App\Models\TechnicalSkill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;

class PuestoController extends Controller
{


    public function index()
    {
        $puestos = Job::all();
        return view('puestos.index')
            ->with('puestos', $puestos);
    }


    public function show($id)
    {
        $puesto = Job::findOrFail($id);

        return view('puestos.show')
            ->with('puesto', $puesto);
    }

    public function areas(Request $request)
    {
        $areas = Job::query()
            ->select('area')
            ->orderBy('area')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('area', 'like', "%{$request->search}%")

            )
            ->distinct('area')
            ->get();
        return $areas;
    }
    public function departamentos(Request $request)
    {
        logger($request->area);
        if ($request->area) {
            $areas = Job::query()
                ->select('departamento')
                ->orderBy('departamento')
                ->when(
                    $request->search,
                    fn(Builder $query) => $query
                        ->where('departamento', 'like', "%{$request->search}%")

                )
                ->where('area', $request->area)
                ->distinct('departamento')
                ->get();
            return $areas;
        }
    }
    // public function puesto($id)
    // {
    //     $puesto = Job::with(['descripcion'])
    //         ->findOrFail($id);

    //     return view('puestos.descripciones.puesto')
    //         ->with('puesto', $puesto);
    // }
    // public function puestoGuardar(Request $request, $id)
    // {
    //     $request->validate([
    //         'puesto' => 'required',
    //         'departamento' => 'required',
    //     ]);

    //     $puesto = Job::findOrFail($id);
    //     $puesto->name = $request->puesto;
    //     $puesto->depto_id = $request->departamento;
    //     $puesto->save();

    //     $this->flasher->addSuccess("Información guardada con éxito");
    //     return redirect()->route('puestos.show', $puesto);
    // }

    public function pdf($id)
    {
        $puestos = Job::all();
        $puesto = Job::with(['departamento', 'departamento.area', 'conocimiento'])
            ->findOrFail($id);

        $imgElaboro = $puesto->getFirstMedia('firma-elaboro-descriptivo-puesto');
        $imgReviso = $puesto->getFirstMedia('firma-reviso-descriptivo-puesto');
        $imgAutorizo = $puesto->getFirstMedia('firma-autorizo-descriptivo-puesto');

        $firmas = [];

        $firmas['solicita'] = User::with('job.departamento')->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $imgElaboro?->getCustomProperty('nombre') . '%'])
            ->first();
        $firmas['reviso'] = User::with('job.departamento')->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $imgReviso?->getCustomProperty('nombre') . '%'])
            ->first();
        $firmas['autorizo'] = User::with('job.departamento')->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $imgAutorizo?->getCustomProperty('nombre') . '%'])
            ->first();

        $pdf = PDF::loadView('puestos.pdf', compact('puesto', 'puestos', 'imgElaboro', 'imgReviso', 'imgAutorizo','firmas'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream($puesto->name . '.pdf');
    }
}
