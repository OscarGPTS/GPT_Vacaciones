<?php

namespace App\Livewire\Empleados;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use App\Services\Rrhh\UserSaveService;
use Spatie\LivewireFilepond\WithFilePond;

class FotoComponent extends Component
{
    use WithFilePond;
    // use WithFileUploads;
    use Actions;

    public $empleado, $foto;
    protected $rules = [
        'foto' => 'required|image',
    ];
    public function mount(User $user)
    {
        $this->empleado = $user;
    }
    public function render()
    {
        return view('livewire.empleados.foto-component');
    }

    public function guardar()
    {
        $this->validate();
        try {
            // Ruta temporal del archivo subido
            $tempImagePath = $this->foto->getRealPath();

            // Cargar la imagen con Intervention Image
            $image = Image::make($tempImagePath);
            // Redimensionar la imagen a 800x600 (o el tamaño deseado)
            $image->resize(null, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // Guardar la imagen redimensionada reemplazando la original
            $image->save($tempImagePath);


            $result = $this->foto->storeOnCloudinaryAs('fotos', $this->empleado->id);
            $this->empleado->profile_image = $result->getSecurePath();
            $this->empleado->cloudinary_public_id = $result->getPublicId();

            $this->empleado->save();
            $this->notification()->success(
                $title = 'Foto de colaborador',
                $description = 'Se guardó con éxito'
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                $title = 'Foto de colaborador',
                $description = 'Ocurrió un error'
            );
            logger()->error($e->getMessage());
        }

        $empleado = $this->empleado;
        $userService = new UserSaveService($empleado);
        $userService->sincronizarFoto();
        $this->reset('foto');
    }
}
