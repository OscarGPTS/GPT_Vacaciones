<?php

namespace App\Http\Controllers\Rrhh;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RequisicionPersonal;
use App\Http\Controllers\Controller;

class RequisicionPersonalController extends Controller
{
    public function index()
    {

        $requisiciones = RequisicionPersonal::with(['puesto', 'solicitante'])
            ->orderBy('id', 'desc')
            ->get();

        return view('rrhh.requisiciones_personal.index')
            ->with('requisiciones', $requisiciones);
    }

    public function show($rq_id)
    {
        $requisicion = RequisicionPersonal::with(['puesto', 'solicitante'])
            ->findOrFail($rq_id);

        $history = $requisicion->status()->history()->get();
        return view('rrhh.requisiciones_personal.show')
            ->with([
                'requisicion' => $requisicion,
                'history' => $history
            ]);
    }
    public function pdf($rq_id)
    {
        $requisicion = RequisicionPersonal::with(['puesto', 'solicitante'])
            ->findOrFail($rq_id);


        $pdf = PDF::loadView('rrhh.requisiciones_personal.pdf', compact('requisicion', 'requisicion'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream();
    }
    public function finalizar($rq_id)
    {
        $requisicion = RequisicionPersonal::find($rq_id);
        if ($requisicion->status()->canBe('finalizada')) {
            $requisicion->status()->transitionTo('finalizada');
        }
        return redirect()->back();
    }

    public function notificar($rq_id)
    {
        // $requisicion = RequisicionPersonal::with(['solicitante', 'solicitante.jefe', 'puesto'])
        //     ->find($rq_id);
        // $solicitud = [];
        // $respuesta = 'nada';


        // if ($requisicion->estatus == 1) {
        //     $solicitud = [
        //         'folio' => $requisicion->uuid,
        //         'solicitante' => $requisicion->solicitante->nombre(),
        //         'jefe' => [
        //             'nombre' => $requisicion->solicitante->jefe->nombre(),
        //             'email' => $requisicion->solicitante->jefe->email
        //         ],
        //         'cantidad' => $requisicion->personas_requeridas,
        //         'puesto' => (!empty($requisicion->puesto_solicitado) ? $requisicion->puesto->name : $requisicion->puesto_nuevo),
        //         'ruta' => route('perfil.requisiciones.personal.revisar.index')
        //     ];
        //     Mail::to($solicitud['jefe']['email'])->send(new Revision($solicitud));
        // } elseif ($requisicion->estatus == 2) {
        //     Mail::to('dmreyesr@gptservices.com')->send(new Autorizar($requisicion));
        // }
        // return redirect()->back();
    }
}
