<div>
    <div class="row-gap-3 row">
        {{-- Experiencia --}}
        <div class="col-md-12">
            <x-card title="Experiencia">
                <x-slot name="action">
                    <x-button.circle primary icon="plus" onclick="$openModal('experienciaModal')" />
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Fechas
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Puesto
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($user->cvExperiencia->count() > 0)
                                @foreach ($user->cvExperiencia as $experiencia)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $experiencia->fecha_inicio }} - {{ $experiencia->fecha_final }}
                                    </th>
                                    <td class="px-3 py-2">
                                        {{ $experiencia->puesto }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarExperiencia('{{ $experiencia->id }}')" loading-delay="short"
                                            wire:click="editarExperiencia('{{ $experiencia->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarExperiencia('{{ $experiencia->id }}')" loading-delay="short"
                                            wire:click="borrarExperiencia('{{ $experiencia->id }}')" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
        @if ($editRrhh)
        {{-- Cursos y certificaciones externos --}}
        <div class="col-md-12">
            <x-card title="Cursos y certificaciones externos">
                <x-slot name="action">
                    <div>
                        <x-button.circle primary icon="plus" wire:click="crearCursoExterno" />
                    </div>
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cursosExternos) > 0)
                                @foreach ($cursosExternos as $curso)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $curso->nombre }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarCursoExterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="editarCursoExterno('{{ $curso->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarCursoExterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="borrarCursoExterno('{{ $curso->id }}')" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                </div>
            </x-card>
        </div>
        {{-- Cursos y certificaciones internos --}}
        <div class="col-md-12">
            <x-card title="Cursos y certificaciones internas">
                <x-slot name="action">
                    <div>
                        <x-button.circle primary icon="plus" wire:click="crearCursoInterno" />
                    </div>
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cursosInternos) > 0)
                                @foreach ($cursosInternos as $curso)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $curso->nombre }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarCursoInterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="editarCursoInterno('{{ $curso->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarCursoInterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="borrarCursoInterno('{{ $curso->id }}')" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
        @else
        {{-- Cursos y certificaciones externos --}}
        <div class="col-md-12">
            <x-card title="Cursos y certificaciones externos">
                <x-slot name="action">
                    <div>
                        <x-button.circle primary icon="plus" wire:click="crearCursoExterno" />
                    </div>
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cursosExternos) > 0)
                                @foreach ($cursosExternos as $curso)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $curso->nombre }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarCursoExterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="editarCursoExterno('{{ $curso->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarCursoExterno('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="borrarCursoExterno('{{ $curso->id }}')" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
        @endif
        {{-- Certificaciones de soldadura --}}
        @if (in_array($user->id, $users_soldadura))
        <div class="col-md-12">
            <x-card title="Certificaciones de soldadura">
                <x-slot name="action">
                    <div>
                        <x-button.circle primary icon="plus" wire:click="crearCursoSoldadura" />
                    </div>
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cursosSoldadura->count() > 0)
                                @foreach ($cursosSoldadura as $curso)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $curso->nombre }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarCursoSoldadura('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="editarCursoSoldadura('{{ $curso->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarCursoSoldadura('{{ $curso->id }}')" loading-delay="short"
                                            wire:click="borrarCursoSoldadura('{{ $curso->id }}')" />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
        @endif

        {{-- Historial --}}
        @if ($user->showHistorialServicios())
        <div class="col-md-12">
            <x-card title="Historial de servicios">
                <x-slot name="action">
                    <x-button.circle primary icon="plus" onclick="$openModal('historialServicioModal')" />
                </x-slot>
                <div>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                @if ($formato == 1)
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Cliente
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Servicio
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Alcance
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Ramal
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Año
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Mes
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Ubicación
                                    </th>
                                </tr>
                                @endif
                                @if ($formato == 2)
                                <tr>
                                    <th scope="col" class="px-3 py-3">
                                        Cliente
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Tipo de servicio
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Cabezal
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Ramal
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Clase ANSI
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Año
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Ubicación
                                    </th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if ($user->cvHistorialServicio->count() > 0)
                                @foreach ($user->cvHistorialServicio as $servicio)
                                @if ($formato == 1)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->cliente }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->servicio }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->alcance }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->ramal }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->year }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->mes }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->ubicacion }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarServicio('{{ $servicio->id }}')" loading-delay="short"
                                            wire:click="editarServicio('{{ $servicio->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarServicio('{{ $servicio->id }}')" loading-delay="short"
                                            wire:click="borrarServicio('{{ $servicio->id }}')" />
                                    </td>
                                </tr>
                                @endif
                                @if ($formato == 2)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->cliente }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->servicio }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->cabezal }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->ramal }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->clase }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->year }}
                                    </th>
                                    <th scope="row"
                                        class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $servicio->ubicacion }}
                                    </th>
                                    <td class="px-3 py-2 text-right">
                                        <x-button.circle primary icon="pencil"
                                            spinner="editarServicio('{{ $servicio->id }}')" loading-delay="short"
                                            wire:click="editarServicio('{{ $servicio->id }}')" />
                                        <x-button.circle negative icon="minus"
                                            spinner="borrarServicio('{{ $servicio->id }}')" loading-delay="short"
                                            wire:click="borrarServicio('{{ $servicio->id }}')" />
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
        @endif

    </div>

    {{-- Modal experiencia --}}
    <x-modal.card title="Experiencia" blur wire:model="experienciaModal">
        <div class="row">
            <div class="col-md-4">
                <x-datetime-picker label="Fecha de inicio" without-time="true"
                    wire:model="itemExperiencia.fecha_inicio" />
            </div>
            <div class="col-md-4">
                @if ($itemExperiencia->actualmente_laborando)
                <x-datetime-picker label="Fecha de término" without-time="true" x-model="inputValue"
                    wire:model="itemExperiencia.fecha_final" disabled />
                @else
                <x-datetime-picker label="Fecha de término" without-time="true" x-model="inputValue"
                    wire:model="itemExperiencia.fecha_final" />
                @endif
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <x-checkbox id="actualmente" label="Actualmente"
                        wire:model.live="itemExperiencia.actualmente_laborando" />
                </div>
            </div>
            <div class="col-md-12">
                <x-input wire:model="itemExperiencia.puesto" label="Puesto" />
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat label="Cancelar" x-on:click="close" />
                <x-button primary label="Guardar" wire:click="guardarExperiencia" spinner="guardarExperiencia"
                    loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>
    {{-- Modal Historial de servicios --}}
    <x-modal.card title="Servicio" blur wire:model="historialServicioModal">
        @if ($formato == 1)
        <div class="row">
            <div class="col-md-12">
                <x-select label="Cliente" :options="[
                      'ABSOLUT',
                        'ARSEAL',
                        'AVANZIA',
                        'ADS',
                        'AMI ENERGY',
                        'ATEDSA',
                        'ATASTA',
                        'BIG ELK',
                        'BONATTI',
                        'BUZCA',
                        'CELANICE',
                        'CENAGAS',
                        'CEPAM',
                        'CMG',
                        'COAST OIL DYNAMIC',
                        'CODEMON',
                        'CONDISA',
                        'CORRUBOX',
                        'COTEMAR',
                        'CONSTRUCTORA ANDREY',
                        'CPA',
                        'CPC O&G',
                        'CUGAS',
                        'CCC',
                        'CCR',
                        'CIPSI',
                        'CGE',
                        'CONTINENTAL',
                        'CORSA',
                        'COMURSA',
                        'DEMAR',
                        'DIAVAZ',
                        'DMPG',
                        'DUFROMEX',
                        'DIDSA',
                        'EIGSA',
                        'ENGIE',
                        'ERGON',
                        'ESEASA',
                        'ESSENTIA',
                        'ETM',
                        'EMERSON',
                        'FERMACA',
                        'FRISA',
                        'FORZA ECOSISTEMAS',
                        'GAES',
                        'GAIA',
                        'GCI',
                        'GENSA',
                        'GNF',
                        'GNM',
                        'GIMAN',
                        'GNN',
                        'GRUPO SODI',
                        'GS O&G',
                        'HMM/CFE',
                        'IENOVA',
                        'IESA',
                        'IGASAMEX',
                        'IN LINE',
                        'INLINE',
                        'INOVA',
                        'INTERCOMPANY',
                        'INVAL',
                        'INDHECA',
                        'ICA FLUOR',
                        'ISOLUX',
                        'JDM',
                        'JR RAMOS BREACH',
                        'JPDR',
                        'KIEWIT',
                        'MAGA',
                        'MAYURSE',
                        'MEPI',
                        'MEXCEL',
                        'MAXIGAS',
                        'MAQUIALSA', //2
                        'NAES CORPORATION',
                        'NATURGY',
                        'NEWPEK',
                        'NUVOIL',
                        'NUCOR',
                        'OXICA',
                        'OMA',
                        'PEDRO GARCÍA',
                        'PEMEX LOG',
                        'PEP',
                        'PERMADUCTO',
                        'PIFUSA',
                        'PIMEX',
                        'PJP4',
                        'PROASA',
                        'PROTEXA',
                        'PRAXAIR',
                        'PTI',
                        'RHEMA',
                        'SARREAL',
                        'SCHUCK',
                        'SEMPRA',
                        'SICIM',
                        'SNR',
                        'SOLTEC',
                        'STATS USA',
                        'SUBTEC',
                        'SUBSEA 7',
                        'TC ENERGY',
                        'TERMOTÉCNICA COI',
                        'TREKANT',
                        'TOMZA',
                        'WELDFIT',
                        'ZAO',
                    ]" wire:model="itemHistorial.cliente" />
            </div>
            <div class="col-md-12">
                <x-select label="Servicio" :options="[
                        ['name' => 'Hot Tapping', 'id' => 'Hot Tapping', 'description' => 'Hot Tap'],
                        ['name' => 'Prueba Hidrostática', 'id' => 'Prueba Hidrostática'],
                        ['name' => 'Corte en frío', 'id' => 'Corte en frío'],
                        [ 'name' => 'Hot Tapping 45 grados','id' => 'Hot Tapping 45 grados','description' => 'Hot Tap'],
                        ['name' => 'Line stopping', 'id' => 'Line stopping', 'description' => 'Line Stop'],
                        ['name' => 'Instalación de tapón','id' => 'Instalación de tapón','description' => 'Line Stop'],
                        ['name' => 'Doble line stopping', 'id' => 'Doble line stopping', 'description' => 'Line Stop'],
                        ['name' => 'Retiro de tapón', 'id' => 'Retiro de tapón', 'description' => 'Line Stop'],
                        [ 'name' => 'DLS by pass independiente', 'id' => 'DLS by pass independiente', 'description' => 'Line Stop'],
                        [ 'name' => 'DLS by pass en housing', 'id' => 'DLS by pass en housing', 'description' => 'Line Stop'],
                        ['name' => 'Drilling', 'id' => 'Drilling'],
                        ['name' => 'Submarino', 'id' => 'Submarino'],
                        [ 'name' => 'Soldadura en servicio', 'id' => 'Soldadura en servicio', 'description' => 'Soldadura',],
                        ['name' => 'Soldadura branch', 'id' => 'Soldadura branch', 'description' => 'Soldadura'],
                        ['name' => 'Soldadura a tope', 'id' => 'Soldadura a tope', 'description' => 'Soldadura'],
                        ['name' => 'Torque', 'id' => 'Torque'],
                        ['name' => 'Maniobra y montaje', 'id' => 'Maniobra y montaje'],
                        ['name' => 'Servicio integral', 'id' => 'Servicio integral'],
                        ['name' => 'Fabricación', 'id' => 'Fabricación'],
                        ['name' => 'Recubrimiento', 'id' => 'Recubrimiento'],
                    ]" option-label="name" option-value="id" wire:model="itemHistorial.servicio" />
            </div>
            <div class="col-md-12">
                <x-input wire:model="itemHistorial.alcance" label="Alcance" />
            </div>
            <div class="mb-3 col-md-12">
                <x-select label="Ramal" :options='[
                        "2\"",
                        "3\"",
                        "4\"",
                        "5\"",
                        "6\"",
                        "7\"",
                        "8\"",
                        "9\"",
                        "10\"",
                        "11\"",
                        "12\"",
                        "13\"",
                        "14\"",
                        "15\"",
                        "16\"",
                        "17\"",
                        "18\"",
                        "19\"",
                        "20\"",
                        "21\"",
                        "22\"",
                        "23\"",
                        "24\"",
                        "25\"",
                        "26\"",
                        "27\"",
                        "28\"",
                        "29\"",
                        "30\"",
                        "31\"",
                        "32\"",
                        "33\"",
                        "34\"",
                        "35\"",
                        "36\"",
                        "37\"",
                        "38\"",
                        "39\"",
                        "40\"",
                        "41\"",
                        "42\"",
                        "43\"",
                        "44\"",
                        "45\"",
                        "46\"",
                        "47\"",
                        "48\"",
                    ]' wire:model="itemHistorial.ramal" />
            </div>
            <div class="col-md-6">
                <x-select label="Año" :options="[
                        2000,
                        2001,
                        2002,
                        2003,
                        2004,
                        2005,
                        2006,
                        2007,
                        2008,
                        2009,
                        2010,
                        2011,
                        2012,
                        2013,
                        2014,
                        2015,
                        2016,
                        2017,
                        2018,
                        2019,
                        2020,
                        2021,
                        2022,
                        2023,
                        2024,
                        2025,
                    ]" wire:model="itemHistorial.year" />
            </div>
            <div class="col-md-6">
                <x-select label="Mes" :options="['01', '02', '03', '04', '05', '06', '07', '08', '09', 10, 11, 12]"
                    wire:model="itemHistorial.mes" />
            </div>
            <div class="col-md-6">
                <x-select label="Ubicación nacional" :options="[
                        'Aguascalientes',
                        'Baja California',
                        'Baja California Sur',
                        'Campeche',
                        'Chiapas',
                        'Chihuahua',
                        'Coahuila',
                        'Colima',
                        'Durango',
                        'Guanajuato',
                        'Guerrero',
                        'Hidalgo',
                        'Jalisco',
                        'México',
                        'Michoacán',
                        'Morelos',
                        'Nayarit',
                        'Nuevo León',
                        'Oaxaca',
                        'Puebla',
                        'Querétaro',
                        'Quintana Roo',
                        'San Luis Potosí',
                        'Sinaloa',
                        'Sonora',
                        'Tabasco',
                        'Tamaulipas',
                        'Tlaxcala',
                        'Veracruz',
                        'Yucatán',
                        'Zacatecas',
                    ]" wire:model="itemHistorial.ubicacion" />
            </div>
            <div class="col-md-6">
                <x-select label="Ubicación internacional" :options="['Colombia', 'República Dominicana']"
                    wire:model="itemHistorial.ubicacion" />
            </div>
        </div>
        @endif
        @if ($formato == 2)
        <div class="row">
            <div class="col-md-12">
                <x-select label="Cliente" :options="[
                        'ABSOLUT',
                        'ARSEAL',
                        'AVANZIA',
                        'ADS',
                        'AMI ENERGY',
                        'ATEDSA',
                        'ATASTA',
                        'BIG ELK',
                        'BONATTI',
                        'BUZCA',
                        'CELANICE',
                        'CENAGAS',
                        'CEPAM',
                        'CMG',
                        'COAST OIL DYNAMIC',
                        'CODEMON',
                        'CONDISA',
                        'CORRUBOX',
                        'COTEMAR',
                        'CONSTRUCTORA ANDREY',
                        'CPA',
                        'CPC O&G',
                        'CUGAS',
                        'CCC',
                        'CCR',
                        'CIPSI',
                        'CGE',
                        'CONTINENTAL',
                        'CORSA',
                        'COMURSA',
                        'DEMAR',
                        'DIAVAZ',
                        'DMPG',
                        'DUFROMEX',
                        'DIDSA',
                        'EIGSA',
                        'ENGIE',
                        'ERGON',
                        'ESEASA',
                        'ESSENTIA',
                        'ETM',
                        'EMERSON',
                        'FERMACA',
                        'FRISA',
                        'FORZA ECOSISTEMAS',
                        'GAES',
                        'GAIA',
                        'GCI',
                        'GENSA',
                        'GNF',
                        'GNM',
                        'GIMAN',
                        'GNN',
                        'GRUPO SODI',
                        'GS O&G',
                        'HMM/CFE',
                        'IENOVA',
                        'IESA',
                        'IGASAMEX',
                        'IN LINE',
                        'INLINE',
                        'INOVA',
                        'INTERCOMPANY',
                        'INVAL',
                        'INDHECA',
                        'ICA FLUOR',
                        'ISOLUX',
                        'JDM',
                        'JR RAMOS BREACH',
                        'JPDR',
                        'KIEWIT',
                        'MAGA',
                        'MAYURSE',
                        'MEPI',
                        'MEXCEL',
                        'MAXIGAS',
                        'MAQUIALSA', //2
                        'NAES CORPORATION',
                        'NATURGY',
                        'NEWPEK',
                        'NUVOIL',
                        'NUCOR',
                        'OXICA',
                        'OMA',
                        'PEDRO GARCÍA',
                        'PEMEX LOG',
                        'PEP',
                        'PERMADUCTO',
                        'PIFUSA',
                        'PIMEX',
                        'PJP4',
                        'PROASA',
                        'PROTEXA',
                        'PRAXAIR',
                        'PTI',
                        'RHEMA',
                        'SARREAL',
                        'SCHUCK',
                        'SEMPRA',
                        'SICIM',
                        'SNR',
                        'SOLTEC',
                        'STATS USA',
                        'SUBTEC',
                        'SUBSEA 7',
                        'TC ENERGY',
                        'TERMOTÉCNICA COI',
                        'TREKANT',
                        'TOMZA',
                        'WELDFIT',
                        'ZAO',
                    ]" wire:model="itemHistorial.cliente" />
            </div>
            <div class="col-md-12">
                <x-select label="Servicio" :options="[
                        ['name' => 'Hot Tapping', 'id' => 'Hot Tapping', 'description' => 'Hot Tap'],
                        ['name' => 'Prueba Hidrostática', 'id' => 'Prueba Hidrostática'],
                        ['name' => 'Corte en frío', 'id' => 'Corte en frío'],
                        [
                            'name' => 'Hot Tapping 45 grados',
                            'id' => 'Hot Tapping 45 grados',
                            'description' => 'Hot Tap',
                        ],
                        ['name' => 'Line stopping', 'id' => 'Line stopping', 'description' => 'Line Stop'],
                        [
                            'name' => 'Instalación de tapón',
                            'id' => 'Instalación de tapón',
                            'description' => 'Line Stop',
                        ],
                        ['name' => 'Doble line stopping', 'id' => 'Doble line stopping', 'description' => 'Line Stop'],
                        ['name' => 'Retiro de tapón', 'id' => 'Retiro de tapón', 'description' => 'Line Stop'],
                        [
                            'name' => 'DLS by pass independiente',
                            'id' => 'DLS by pass independiente',
                            'description' => 'Line Stop',
                        ],
                        [
                            'name' => 'DLS by pass en housing',
                            'id' => 'DLS by pass en housing',
                            'description' => 'Line Stop',
                        ],
                        ['name' => 'Drilling', 'id' => 'Drilling'],
                        ['name' => 'Submarino', 'id' => 'Submarino'],
                        [
                            'name' => 'Soldadura en servicio',
                            'id' => 'Soldadura en servicio',
                            'description' => 'Soldadura',
                        ],
                        ['name' => 'Soldadura branch', 'id' => 'Soldadura branch', 'description' => 'Soldadura'],
                        ['name' => 'Soldadura a tope', 'id' => 'Soldadura a tope', 'description' => 'Soldadura'],
                        ['name' => 'Torque', 'id' => 'Torque'],
                        ['name' => 'Maniobra y montaje', 'id' => 'Maniobra y montaje'],
                        ['name' => 'Servicio integral', 'id' => 'Servicio integral'],
                        ['name' => 'Fabricación', 'id' => 'Fabricación'],
                        ['name' => 'Recubrimiento', 'id' => 'Recubrimiento'],
                        ['name' => 'OBTURACION DOBLE CON GLOBO OBTURADOR', 'id' => 'OBTURACION DOBLE CON GLOBO OBTURADOR'],
                        ['name' => 'OBTURACIÓN DOBLE', 'id' => 'OBTURACIÓN DOBLE'],
                        ['name' => 'HOT TAPPING CONCRETO', 'id' => 'HOT TAPPING CONCRETO'],
                    ]" option-label="name" option-value="id" wire:model="itemHistorial.servicio" />
            </div>
            <div class="col-md-12">
                <x-select label="Cabezal" :options='[
                        "2\"",
                        "3\"",
                        "4\"",
                        "5\"",
                        "6\"",
                        "7\"",
                        "8\"",
                        "9\"",
                        "10\"",
                        "11\"",
                        "12\"",
                        "13\"",
                        "14\"",
                        "15\"",
                        "16\"",
                        "17\"",
                        "18\"",
                        "19\"",
                        "20\"",
                        "21\"",
                        "22\"",
                        "23\"",
                        "24\"",
                        "25\"",
                        "26\"",
                        "27\"",
                        "28\"",
                        "29\"",
                        "30\"",
                        "31\"",
                        "32\"",
                        "33\"",
                        "34\"",
                        "35\"",
                        "36\"",
                        "37\"",
                        "38\"",
                        "39\"",
                        "40\"",
                        "41\"",
                        "42\"",
                        "43\"",
                        "44\"",
                        "45\"",
                        "46\"",
                        "47\"",
                        "48\"",
                    ]' wire:model="itemHistorial.cabezal" />
            </div>
            <div class="col-md-12">
                <x-select label="Ramal" :options='[
                        "2\"",
                        "3\"",
                        "4\"",
                        "5\"",
                        "6\"",
                        "7\"",
                        "8\"",
                        "9\"",
                        "10\"",
                        "11\"",
                        "12\"",
                        "13\"",
                        "14\"",
                        "15\"",
                        "16\"",
                        "17\"",
                        "18\"",
                        "19\"",
                        "20\"",
                        "21\"",
                        "22\"",
                        "23\"",
                        "24\"",
                        "25\"",
                        "26\"",
                        "27\"",
                        "28\"",
                        "29\"",
                        "30\"",
                        "31\"",
                        "32\"",
                        "33\"",
                        "34\"",
                        "35\"",
                        "36\"",
                        "37\"",
                        "38\"",
                        "39\"",
                        "40\"",
                        "41\"",
                        "42\"",
                        "43\"",
                        "44\"",
                        "45\"",
                        "46\"",
                        "47\"",
                        "48\"",
                    ]' wire:model="itemHistorial.ramal" />
            </div>
            <div class="col-md-12">
                <x-select label="Clase ANSI" :options="[150, 300, 600, 900, 1500]" wire:model="itemHistorial.clase" />
            </div>
            <div class="col-md-6">
                <x-select label="Año" :options="[
                        2000,
                        2001,
                        2002,
                        2003,
                        2004,
                        2005,
                        2006,
                        2007,
                        2008,
                        2009,
                        2010,
                        2011,
                        2012,
                        2013,
                        2014,
                        2015,
                        2016,
                        2017,
                        2018,
                        2019,
                        2020,
                        2021,
                        2022,
                        2023,
                        2024,
                        2025,
                    ]" wire:model="itemHistorial.year" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-select label="Ubicación nacional" :options="[
                        'Aguascalientes',
                        'Baja California',
                        'Baja California Sur',
                        'Campeche',
                        'Chiapas',
                        'Chihuahua',
                        'Coahuila',
                        'Colima',
                        'Durango',
                        'Guanajuato',
                        'Guerrero',
                        'Hidalgo',
                        'Jalisco',
                        'México',
                        'Michoacán',
                        'Morelos',
                        'Nayarit',
                        'Nuevo León',
                        'Oaxaca',
                        'Puebla',
                        'Querétaro',
                        'Quintana Roo',
                        'San Luis Potosí',
                        'Sinaloa',
                        'Sonora',
                        'Tabasco',
                        'Tamaulipas',
                        'Tlaxcala',
                        'Veracruz',
                        'Yucatán',
                        'Zacatecas',
                    ]" wire:model="itemHistorial.ubicacion" />
            </div>
            <div class="col-md-6">
                <x-select label="Ubicación internacional" :options="['Colombia', 'República Dominicana']"
                    wire:model="itemHistorial.ubicacion" />
            </div>
        </div>
        @endif
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat label="Cancelar" x-on:click="close" />
                <x-button primary label="Guardar" wire:click="guardarServicio" spinner="guardarServicio"
                    loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>

    {{-- Modal Cursos / Certificaciones externo --}}
    <x-modal.card title="Cursos / Certificaciones externos" blur wire:model="cursoModalExterno">
        <div>
            <x-input wire:model="itemCurso.nombre" label="Nombre del curso o certificado" placeholder="Capacitación, uso y manejo de equipo de Hot Tapping T-106, 360, 760 realizando
            perforaciones de ½” hasta 12”." />
        </div>
        <div>
            <x-select label="Año" :options="[
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
                '2006',
                '2007',
                '2008',
                '2009',
                '2010',
                '2011',
                '2012',
                '2013',
                '2014',
                '2015',
                '2016',
                '2017',
                '2018',
                '2019',
                '2020',
                '2021',
                '2022',
                '2023',
                '2024',
                '2025',
            ]" wire:model="itemCurso.year" />
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat label="Cancelar" x-on:click="close" />
                <x-button primary label="Guardar" wire:click="guardarCursoExterno" spinner="guardarCursoExterno"
                    loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>

    {{-- Modal Cursos / Certificaciones interno --}}
    <x-modal.card title="Cursos / Certificaciones internas" blur wire:model="cursoModalInterno">
        <div>
            <x-input wire:model="itemCurso.nombre" label="Nombre del curso o certificado"
                placeholder="Capacitación, uso y manejo de equipo de Hot Tapping T-106" />
        </div>
        <div>
            <x-select label="Año" :options="[
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
                '2006',
                '2007',
                '2008',
                '2009',
                '2010',
                '2011',
                '2012',
                '2013',
                '2014',
                '2015',
                '2016',
                '2017',
                '2018',
                '2019',
                '2020',
                '2021',
                '2022',
                '2023',
                '2024',
                '2025',
            ]" wire:model="itemCurso.year" />
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat label="Cancelar" x-on:click="close" />
                <x-button primary label="Guardar" wire:click="guardarCursoInterno" spinner="guardarCursoInterno"
                    loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>

    {{-- Modal Cursos / Certificaciones de soldadura --}}
    <x-modal.card title="Certificacion de soldadura" blur wire:model="cursoModalSoldadura">
        <div class="row">
            <div class="col-md-12">
                <x-input wire:model="itemCursoSoldadura.nombre" label="Nombre del curso o certificado" />
            </div>
            <div class="col-md-6">
                <x-input wire:model="itemCursoSoldadura.proceso" label="Proceso" />
            </div>
            <div class="col-md-6">
                <x-input wire:model="itemCursoSoldadura.wps" label="WPS" />
            </div>
            <div class="col-md-6">
                <x-select label="Desde" :options="[
                    '2000',
                    '2001',
                    '2002',
                    '2003',
                    '2004',
                    '2005',
                    '2006',
                    '2007',
                    '2008',
                    '2009',
                    '2010',
                    '2011',
                    '2012',
                    '2013',
                    '2014',
                    '2015',
                    '2016',
                    '2017',
                    '2018',
                    '2019',
                    '2020',
                    '2021',
                    '2022',
                    '2023',
                    '2024',
                    '2025',
                ]" wire:model="itemCursoSoldadura.desde" />
            </div>
            <div class="col-md-6">
                <x-select label="Hasta" :options="[
                    '2000',
                    '2001',
                    '2002',
                    '2003',
                    '2004',
                    '2005',
                    '2006',
                    '2007',
                    '2008',
                    '2009',
                    '2010',
                    '2011',
                    '2012',
                    '2013',
                    '2014',
                    '2015',
                    '2016',
                    '2017',
                    '2018',
                    '2019',
                    '2020',
                    '2021',
                    '2022',
                    '2023',
                    '2024',
                    '2025',
                    'Vigente',
                ]" wire:model="itemCursoSoldadura.hasta" />
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat label="Cancelar" x-on:click="close" />
                <x-button primary label="Guardar" wire:click="guardarCursoSoldadura" spinner="guardarCursoSoldadura"
                    loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
