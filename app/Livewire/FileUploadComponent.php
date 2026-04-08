<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Computed;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class FileUploadComponent extends Component
{
    use WithFileUploads;
    use Actions;
    public $typeRules = 'img';
    public $newFile, $fileName;
    public $model, $modelClass, $idModel, $mediaCollectionName;

    public function mount()
    {
        $this->model = $this->modelClass::findOrFail($this->idModel);
    }

    public function rules()
    {
        if ($this->typeRules == 'img') {
            return [
                'fileName' => 'required',
                'newFile' => 'file|mimes:jpg,jpeg,png|max:1000'
            ];
        }
        if ($this->typeRules == 'excel') {
            return [
                'fileName' => 'required',
                'newFile' => 'file|mimes:xls,xlsx|max:5000'
            ];
        }
    }
    public function messages()
    {
        if ($this->typeRules == 'img') {
            return [
                'fileName.required' => 'Este campo no puede estar vacío.',
                'newFile.file' => 'Debe cargar un archivo.',
                'newFile.mimes' => 'El nuevo archivo debe ser un archivo de tipo: jpg, jpeg, png.',
            ];
        }
        if ($this->typeRules == 'excel') {
            return [
                'fileName.required' => 'Este campo no puede estar vacío.',
                'newFile.file' => 'Debe cargar un archivo.',
                'newFile.mimes' => 'El nuevo archivo debe ser un archivo de tipo: Excel.',
            ];
        }
    }

    public function render()
    {
        return view('livewire.file-upload-component');
    }

    public function updatedFileName()
    {
        $this->resetErrorBag();
    }
    public function updatedNewFile()
    {
        $this->resetErrorBag();
        if ($this->newFile) {
            $this->fileName = pathinfo($this->newFile->getClientOriginalName(), PATHINFO_FILENAME);
        } else {
            $this->fileName = '';
        }
    }
    public function deleteFileDB($index)
    {
        $this->files[$index]->delete();
        unset($this->files[$index]);

        $this->notification()->error(
            $title = 'Archivo eliminado',
            $description = 'El  archivo fue eliminado   exitosamente'
        );
    }

    public function guardar()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->model
                ->addMedia($this->newFile->getRealPath())
                ->usingName($this->fileName)
                ->toMediaCollection($this->mediaCollectionName);
            DB::afterCommit(function () {
                $this->reset(['newFile', 'fileName']);
                // $this->dispatch('resetFilePond');
                $this->dispatch('resetFilePond');
                $this->notification()->success(
                    $title = 'Archivo guardado',
                    $description = 'El archivo fue guardado exitosamente'
                );
                $this->model->refresh();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            throw ($e);
        }
    }

    public function getFilesProperty()
    {
        return $this->model->getMedia($this->mediaCollectionName);
    }
}
