<?php

namespace App\Livewire\Empleados;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\CvCursoCertificacion;

class UploadExcelCursoCertificacion extends Component
{
    use Actions;
    use WithFileUploads;
    public $excelCursosModal = false;
    public $file, $cursos;

    protected $rules = [
        'file' => 'required|mimes:xls,xlsx',
    ];
    public function mount()
    {
    }
    public function render()
    {
        return view('livewire.empleados.upload-excel-curso-certificacion');
    }

    public function guardar()
    {
        $this->validate();
        $this->cursos = fastexcel()->import($this->file->path());

        $this->validate([
            'cursos.*.id' => 'required|numeric',
            'cursos.*.tema' => 'required|string',
            'cursos.*.fecha' => 'required',
        ]);

        // Validar si hacen match los id del excel con los de la base de datos
        $idsDB = User::get()->pluck('id');
        $idsExcel = $this->cursos->pluck('id');
        $idsExcel = collect($idsExcel);
        $idsDB = collect($idsDB);
        $diff = $idsExcel->diff($idsDB)->all();
        if (count($diff) > 0) {
            $ids = implode(",", $diff);
            $this->addError('excel', 'Los siguientes ID´S de empleado no existen en la plataforma: ' . $ids);
            return;
        }

        $data = [];
        foreach ($this->cursos as $item) {
            $fecha_string = Carbon::parse($item['fecha'])->toDateTimeString();;
            // Convierte el string a una marca de tiempo (timestamp)
            $timestamp = strtotime($fecha_string);
            // Obtiene el año de la marca de tiempo
            $year = date("Y", $timestamp);
            $data[] = [
                'nombre' => $item['tema'],
                'tipo' => 'interno',
                'year' => $year,
                'user_id' => $item['id'],
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }
        try {
            DB::beginTransaction();
            $insert = CvCursoCertificacion::insert($data);
            DB::afterCommit(function () use ($data) {
                $this->excelCursosModal = false;
                $this->notification()->success(
                    $title = 'Excel',
                    $description = 'Se guardaron ' . count($data) . ' registros de cursos/certificaciones internos.'
                );
            });
            DB::commit();
        } catch (Exception $e) {
            $this->excelCursosModal = false;
            $this->notification()->error(
                $title = 'Excel',
                $description = 'Ocurrió un error al guardar la información'
            );
            logger()->error($e->getMessage());
            DB::rollback();
        }
        $this->file->delete();
        $this->reset('file');
    }
}
