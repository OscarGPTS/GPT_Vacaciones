<?php

namespace App\Livewire;

use App\Models\RequestVacations;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ListRequestComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    /**
     * @var Request $request La solicitud actual.
     * @var array $archivos_permiso Los archivos de permiso.
     * @var bool $editarJustificante Indica si se está editando el justificante.
     */
    public $request, $archivos_permiso, $editarJustificante;

    /**
     * Renderiza el componente.
     *
     * @return \Illuminate\View\View La vista del componente.
     */
    public function render()
    {
        $myrequests = auth()->user()->requestDone()
            ->where('visible', true)
            ->with(['user', 'directManager', 'approvedRequests', 'rejectedRequests'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
            
        return view('livewire.list-request-component', ['myrequests' => $myrequests]);
    }

    /**
     * Elimina una solicitud.
     *
     * @param Request $request La solicitud a eliminar.
     * @return void
     */
    public function deleteRequest(RequestVacations $request)
    {
        $request->visible = false;
        $request->save();
        session()->flash('message', 'Solicitud Eliminada Correctamente.');
    }

    /**
     * Muestra los detalles de una solicitud.
     *
     * @param Request $request La solicitud a mostrar.
     * @return void
     */
    public function showRequest(RequestVacations $request)
    {
        $this->request = $request;
        $this->editarJustificante = $request->doc_permiso == null ? true : false;
        $this->dispatchBrowserEvent('showRequest');
    }

    /**
     * Sube el justificante de una solicitud.
     *
     * @param Request $modelRequest La solicitud a la que se subirá el justificante.
     * @return void
     */
    public function subirJustificante(RequestVacations $modelRequest)
    {
        $this->validate([
            'archivos_permiso' => 'required|array',
        ]);

        // Eliminar los archivos anteriores
        if ($modelRequest->doc_permiso != null) {
            $docPermisosAnteriores =  explode(',', $modelRequest->doc_permiso);
            foreach ($docPermisosAnteriores as $docPermisoAnterior) {
                if ($docPermisoAnterior != null) {
                    unlink(public_path('storage/archivosPermisos/' . $docPermisoAnterior));
                }
            }
        }
        $docPermiso =  [];
        $archivos = $this->archivos_permiso;
        if ($archivos != null) {
            foreach ($archivos as $archivo) {
                $n = $archivo->getClientOriginalName();
                $nombreImagen = time() . ' ' . Str::slug($n) . "." . $archivo->getClientOriginalExtension();
                $archivo->storeAs( 'public/archivosPermisos', $nombreImagen );
                array_push($docPermiso, $nombreImagen);
            }
        }

        $modelRequest->update([
            'doc_permiso' => count($docPermiso) > 0 ? implode(',', $docPermiso) : null,
        ]);
        $this->request = $modelRequest;
        $this->editarJustificante = $modelRequest->doc_permiso == null ? true : false;
        session()->flash('updateFile', 'Archivos Cargado Correctamente.');

        // Redirige de nuevo a donde sea apropiado
    }

    /**
     * Cambia el estado de la variable $editarJustificante.
     *
     * @return void
     */
    public function cambiarEditarJustificante()
    {
        $this->editarJustificante = !$this->editarJustificante;
    }
}
