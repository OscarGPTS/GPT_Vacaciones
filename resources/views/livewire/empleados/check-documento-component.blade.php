<div>
    <div class="row">
        <div class="col-lg-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.index') }}">Lista de empleados</a>
                </li>
                <li class="breadcrumb-item">Empleado</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.show', $user->id) }}">{{ $user->id }}</a>
                </li>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <x-card>
                <div class="flex flex-col items-center gap-4">
                    <img class="w-20 h-20 rounded" src="{{ $user->profile_image }}" alt="Large avatar">
                    <div class="font-medium">
                        <div>{{ $user->nombre() }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->job->name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->admission->format('d-m-Y') }}
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-base font-medium text-blue-700 dark:text-white">Estatus</span>
                            <span class="text-sm font-medium text-blue-700 dark:text-white">{{ $this->avance }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $this->avance }}%"></div>
                        </div>
                    </div>
                    <x-button href="{{ route('empleados.documentos.check.pdf', $user->id) }}" label="PDF" red
                        target="_blank" />
                </div>
            </x-card>
        </div>
        <div class="col-md-5">
            @role('super-admin')
                <x-card>
                    <div class="relative overflow-x-auto overflow-y-auto">
                        <div class="flex items-center justify-center">
                            <table class="w-full text-sm text-left text-gray-500rtl:text-right">
                                <tbody class="bg-gray-50">
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Acta de nacimiento.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="1" wire:model='documento.acta_nacimiento' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Antecedentes clínicos.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap">
                                            @if ($admisionVieja !== 'antes de enero 2020')
                                                <x-checkbox id="2" wire:model='documento.antecedentes_clinicos' />
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Carta compromiso código de ética.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="3"
                                                wire:model='documento.carta_compromiso_codigo_etica' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Carta oferta.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            @if ($admisionVieja !== 'antes de enero 2020')
                                                <x-checkbox id="4" wire:model='documento.carta_oferta' />
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Cartas de recomendación.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            @if ($admisionVieja !== 'antes de enero 2020')
                                                <x-checkbox id="5" wire:model='documento.cartas_recomendacion' />
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Certificado médico.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="6" wire:model='documento.certificado_medico' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Código de ética y conducta.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="7" wire:model='documento.codigo_etica_conducta' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Comprobante de banco.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="8" wire:model='documento.comprobante_banco' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Comprobante de domicilio (no mayor a tres meses).
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="9" wire:model='documento.comprobante_domicilio' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Comprobante de estudios (ultimo).
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="10" wire:model='documento.comprobante_estudios' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Constancia de situación fiscal.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="11" wire:model='documento.constancia_situacion_fiscal' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Cuestionario anticorrupción.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="12" wire:model='documento.cuestionario_anticorrupcion' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            CURP
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="13" wire:model='documento.curp' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            C.V / Solicitud de empleo.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="14" wire:model='documento.cv_solicitud_empleo' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Evaluación de entrevista.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            @if ($admisionVieja == 'antes de enero 2020' || $admisionVieja == 'antes de enero 2022')
                                            @else
                                                <x-checkbox id="15" wire:model='documento.evalucion_entrevista' />
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Formato de aptitud.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            @if ($admisionVieja !== 'antes de enero 2020')
                                                <x-checkbox id="16" wire:model='documento.formato_aptitud' />
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Identificación oficial.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="17" wire:model='documento.identificacion_oficial' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Kit contratación.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="18" wire:model='documento.kit_contratacion' />
                                        </td>
                                    </tr>
                                    <tr class="border-b ">
                                        <td class="p-2">
                                            Número de seguro social.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="19" wire:model='documento.numero_seguro_social' />
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="p-2">
                                            Reglamento interno de trabajo firmado.
                                        </td>
                                        <td class="p-2 font-medium whitespace-nowrap ">
                                            <x-checkbox id="20"
                                                wire:model='documento.reglamento_interno_trabajo_firmado' />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <x-slot name="footer">
                        <div class="flex items-center justify-between">
                            <x-button label="Guardar" positive wire:click="guardar" spinner="guardar"
                                loading-delay="long" />
                        </div>
                    </x-slot>
                </x-card>
            @endrole
        </div>
        <div class="col-md-5">
            @role('super-admin')
                <x-card>
                    <div class="flex items-center justify-center">
                        <table class="w-full text-sm text-left text-gray-500rtl:text-right">
                            <tbody class="bg-gray-50">
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Evaluación de desempeño.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.evaluacion_desempeno" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Evaluación periodo de prueba (90 días).
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']"
                                            wire:model="opcionales.evalucion_periodo_prueba_90_dias" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Convenios especiales o promociones.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']"
                                            wire:model="opcionales.convenios_especiales_promociones" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Solicitud de vacaciones.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.solicitud_vacaciones" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Permisos (pago tiempo por tiempo).
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']"
                                            wire:model="opcionales.permisos_pago_tiempo_por_tiempo" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Incapacidades.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.incapacidades" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Capacitación.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.capacitacion" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Otros documentos (bonos, finiquitos, etc.).
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.otros_documentos" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Acta de matrimonio
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.acta_matrimonio" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Acta de nacimiento de esposa e hijos.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.acta_nacimiento_esposa_hijos" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Aviso de retención de Infonavit.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.aviso_retencion_infonavit" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Aviso de retención FONACOT.
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.aviso_retencion_fonacot" />
                                    </td>
                                </tr>
                                <tr class="border-b ">
                                    <td class="p-2">
                                        Actualización de datos (último).
                                    </td>
                                    <td class="p-2 font-medium whitespace-nowrap ">
                                        <x-select :options="['Si', 'No', 'N/A']" wire:model="opcionales.actualizacion_datos_último" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <x-slot name="footer">
                        <div class="flex items-center justify-between">
                            @if (filled($user->checkDocumento))
                                <x-button label="Guardar" green wire:click="guardarOpcionales"
                                    spinner="guardarOpcionales" loading-delay="long" />
                            @else
                                <x-button label="Guardar" slate disabled />
                            @endif
                        </div>
                    </x-slot>
                </x-card>
            @endrole
        </div>
    </div>
</div>
