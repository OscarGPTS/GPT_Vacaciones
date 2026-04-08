<x-card title="Cursos externos">
    <div class="mb-2 row">
        <div class="col-md-4">
            <x-input label="Nombre del curso" wire:model="cursoNombre" />
        </div>
    </div>
    <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 500KB.</span>
    <p>Cargar PDF</p>
    <x-forms.input-filepond wire:model.live="cursoPDF" accept="application/pdf" maxFileSize="500KB" />
    <div>
        <table class="table table-sm " id="comprobante-domicilio">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre del curso
                    </th>
                    <th scope="col" class="p-2">
                        Fecha de subida
                    </th>
                    <th scope="col" class="p-2">
                        Ver
                    </th>
                    @can('ver modulo rrhh')
                    <th>

                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($cursosCollect))
                    @foreach ($cursosCollect as $key=> $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->created_at->isoFormat('LLL') }}</td>
                            <td> <x-button.circle positive icon="eye" href="{{ $item->getUrl() }}" target="_blank" />
                            </td>
                            @can('ver modulo rrhh')
                            <td>
                                <x-button.circle negative icon="trash" wire:click="deleteFile('cursos_externos',{{ $key }})"  spinner="deleteFile('cursos_externos',{{ $key }})"/>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarCurso' spinner='guardarCurso' />
    </x-slot>
</x-card>
