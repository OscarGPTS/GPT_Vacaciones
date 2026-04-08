<div>
    <div class="row">
        <div class="col-md-12">
            <div id="accordion-collapse" data-accordion="collapse">
                {{-- 1.1 --}}
                <h5 id="accordion-collapse-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="false"
                        aria-controls="accordion-collapse-body-1">
                        <span>1.1 Información del puesto</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-input label="Nombre del puesto" wire:model="puesto.name" />
                                </div>
                                <div class="col-md-4">
                                    <x-select label="Departamento" :options="$departamentos" option-label="name"
                                        option-value="id" wire:model="puesto.depto_id" />
                                </div>
                                <div class="col-md-4">
                                    <x-input label="Area" wire:model.live="puesto.departamento.area.name" readonly />
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_1" spinner="guardar_1_1" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.2 --}}
                <h5 id="accordion-collapse-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                        aria-controls="accordion-collapse-body-2">
                        <span>1.2 Objetivo principal</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <x-textarea
                                        label="Objetivo general del puesto, contribución de acuerdo a los objetivos estratégicos de la Dirección General"
                                        wire:model="puesto.objetivo" />
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_2"  spinner="guardar_1_2" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.3 --}}
                <h5 id="accordion-collapse-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                        aria-controls="accordion-collapse-body-3">
                        <span>1.3 Funciones, responsabilidades y autoridad</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-center justify-content-between">
                                        <p>Responsabilidades:Toma de decisiones.</p>
                                        <x-button.circle green wire:click="nuevaResponsabilidad" icon="plus" />
                                    </div>
                                    @if ($puesto->responsabilidad)
                                        <ul class="list-group">
                                            @foreach ($puesto->responsabilidad as $key => $itemRes)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="px-3">
                                                        <strong>{{ $loop->iteration }}</strong>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Responsabilidad"
                                                            wire:model="puesto.responsabilidad.{{ $key }}.nombre" />
                                                    </div>
                                                    <div>
                                                        <x-select label="Tipo" :options="['total', 'compartida']"
                                                            wire:model.live="puesto.responsabilidad.{{ $key }}.tipo" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        @if ($puesto['responsabilidad'][$key]['tipo'] == 'compartida')
                                                            <x-input label="Compartida con"
                                                                wire:model="puesto.responsabilidad.{{ $key }}.compartida_con" />
                                                        @else
                                                            <x-input label="Compartida con"
                                                                wire:model="puesto.responsabilidad.{{ $key }}.compartida_con"
                                                                disabled />
                                                        @endif

                                                    </div>
                                                    <div class="px-3">
                                                        <x-button.circle negative
                                                            wire:click="borrarResponsabilidad('{{ $key }}')"
                                                            icon="trash" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <hr class="my-3 col">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-between">
                                        <p>Funciones:conjunto de actividades esenciales del trabajo.</p>
                                        <x-button.circle green wire:click="nuevaFuncion" icon="plus" />
                                    </div>
                                    @if ($puesto->funciones)
                                        <ul class="list-group">
                                            @foreach ($puesto->funciones as $key => $funcion)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="px-3">
                                                        <strong>{{ $loop->iteration }}</strong>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input
                                                            wire:model.blur="puesto.funciones.{{ $key }}" />
                                                    </div>
                                                    <div class="px-3">
                                                        <x-button.circle negative
                                                            wire:click="borrarFuncion('{{ $key }}')"
                                                            icon="trash" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_3"  spinner="guardar_1_3" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.4 --}}
                <h5 id="accordion-collapse-heading-4">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-4" aria-expanded="false"
                        aria-controls="accordion-collapse-body-4">
                        <span> 1.4 Clasificación del puesto</p></span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-4"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-center justify-content-evenly">
                                        <x-radio id="operativo" label="OPERATIVO" value="Operativo"
                                            wire:model="puesto.clasificacion" />
                                        <x-radio id="tactico" label="TÁCTICO" value="Táctico"
                                            wire:model="puesto.clasificacion" />
                                        <x-radio id="estrategico" label="ESTRÁTEGICO" value="Estrátegico"
                                            wire:model="puesto.clasificacion" />
                                    </div>
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_4"  spinner="guardar_1_4" loading-delay="short" />
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.5 --}}
                <h5 id="accordion-collapse-heading-5">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-5" aria-expanded="false"
                        aria-controls="accordion-collapse-body-5">
                        <span>1.5 Coordinación y relaciones internas</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-between">
                                        <x-button.circle green wire:click="nuevaRelacionInterna" icon="plus" />
                                    </div>
                                    @if ($puesto->relaciones_internas)
                                        <ul class="list-group">
                                            @foreach ($puesto->relaciones_internas as $key => $funcion)
                                                <li
                                                    class="gap-1 list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="px-3">
                                                        <strong>{{ $loop->iteration }}</strong>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Departamento"
                                                            wire:model="puesto.relaciones_internas.{{ $key }}.depto" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Actividad"
                                                            wire:model="puesto.relaciones_internas.{{ $key }}.actividad" />
                                                    </div>
                                                    <div class="px-3">
                                                        <x-button.circle negative
                                                            wire:click="borrarRelacionInterna('{{ $key }}')"
                                                            icon="trash" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_5"  spinner="guardar_1_5" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.6 --}}
                <h5 id="accordion-collapse-heading-6">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-6" aria-expanded="false"
                        aria-controls="accordion-collapse-body-6">
                        <span>1.6 Coordinación y relaciones externas</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-6" class="hidden" aria-labelledby="accordion-collapse-heading-6"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-between">
                                        <x-button.circle green wire:click="nuevaRelacionExterna" icon="plus" />
                                    </div>
                                    @if ($puesto->relaciones_externas)
                                        <ul class="list-group">
                                            @foreach ($puesto->relaciones_externas as $key => $item)
                                                <li
                                                    class="gap-1 list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="px-3">
                                                        <strong>{{ $loop->iteration }}</strong>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Empresa/Dependencia"
                                                            wire:model="puesto.relaciones_externas.{{ $key }}.empresa" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Motivo"
                                                            wire:model="puesto.relaciones_externas.{{ $key }}.motivo" />
                                                    </div>
                                                    <div class="px-3">
                                                        <x-button.circle negative
                                                            wire:click="borrarRelacionExterna('{{ $key }}')"
                                                            icon="trash" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_6"  spinner="guardar_1_6" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.7 --}}
                <h5 id="accordion-collapse-heading-7">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-7" aria-expanded="false"
                        aria-controls="accordion-collapse-body-7">
                        <span>1.7 Personal a cargo</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-7" class="hidden" aria-labelledby="accordion-collapse-heading-7"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2 d-flex justify-content-between">
                                        <x-button.circle green wire:click="nuevoPersonal" icon="plus" />
                                    </div>
                                    @if ($puesto->personal_cargo)
                                        <ul class="list-group">
                                            @foreach ($puesto->personal_cargo as $key => $item)
                                                <li
                                                    class="gap-1 list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="px-3">
                                                        <strong>{{ $loop->iteration }}</strong>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Puesto a cargo"
                                                            wire:model="puesto.personal_cargo.{{ $key }}.puesto" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <x-input label="Actividad supervisada"
                                                            wire:model="puesto.personal_cargo.{{ $key }}.actividad" />
                                                    </div>
                                                    <div class="px-3">
                                                        <x-button.circle negative
                                                            wire:click="borrarPersonal('{{ $key }}')"
                                                            icon="trash" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_7"  spinner="guardar_1_7" loading-delay="short" />
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.8 --}}
                <h5 id="accordion-collapse-heading-8">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-8" aria-expanded="false"
                        aria-controls="accordion-collapse-body-8">
                        <span> 1.8 Plan de contingencia(en caso de ausencia)</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-8" class="hidden" aria-labelledby="accordion-collapse-heading-8"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input label="Reemplaza a:"
                                        wire:model="puesto.plan_contingencia.reemplaza"
                                        corner-hint="(Plan de contingencia cubre a)" />
                                </div>
                                <div class="col-md-6">
                                    <x-input label="Es reemplazado por:"
                                        wire:model="puesto.plan_contingencia.reemplazo"
                                        corner-hint="(Plan de contingencia en caso de ausencia)" />
                                </div>

                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_8"  spinner="guardar_1_8" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 1.9 --}}
                <h5 id="accordion-collapse-heading-9">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-9" aria-expanded="false"
                        aria-controls="accordion-collapse-body-9">
                        <span> 1.9 Desarrollo</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-9" class="hidden" aria-labelledby="accordion-collapse-heading-9"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input label="Posición que se tiene lista para crecimiento a esta:"
                                        wire:model="puesto.desarrollo.a" />
                                </div>
                                <div class="col-md-6">
                                    <x-input label="Siguiente puesto a ocupar:"
                                        wire:model="puesto.desarrollo.b" />
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_1_9"  spinner="guardar_1_9" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 2.0 --}}
                <h5 id="accordion-collapse-heading-20">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-20" aria-expanded="false"
                        aria-controls="accordion-collapse-body-20">
                        <span>2.0 Ambiente para la operación</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-20" class="hidden" aria-labelledby="accordion-collapse-heading-20"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-select label="Lugar físico de trabajo:" :options="['Oficina', 'Campo', 'Mixto']"
                                        wire:model="puesto.ambiente.lugar_trabajo" />
                                </div>
                                <div class="col-md-4">
                                    <x-select label="Tiempo de Comida:" :options="['1 Hora', 'No aplica']"
                                        wire:model="puesto.ambiente.tiempo_comida" />
                                </div>
                                <div class="col-md-4">
                                    <x-select label="Jornada de Trabajo:" :options="['7:30 - 15:00', '8:30 - 17:30', '8:00 - 14:00']"
                                        wire:model="puesto.ambiente.horario_trabajo" />
                                </div>
                                <div class="col-md-12">
                                    <p>Días de Trabajo:</p>
                                    <div class="d-flex justify-content-evenly align-items-center">
                                        <x-checkbox id="lunes" label="Lunes"
                                            wire:model="puesto.ambiente.lunes" />
                                        <x-checkbox id="martes" label="Martes"
                                            wire:model="puesto.ambiente.martes" />
                                        <x-checkbox id="miercoles" label="Miercoles"
                                            wire:model="puesto.ambiente.miercoles" />
                                        <x-checkbox id="jueves" label="Jueves"
                                            wire:model="puesto.ambiente.jueves" />
                                        <x-checkbox id="viernes" label="Viernes"
                                            wire:model="puesto.ambiente.viernes" />
                                        <x-checkbox id="sabado" label="Sabado"
                                            wire:model="puesto.ambiente.sabado" />
                                        <x-checkbox id="domingo" label="Domingo"
                                            wire:model="puesto.ambiente.domingo" />
                                    </div>
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_2_0"  spinner="guardar_2_0" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 2.1 --}}
                <h5 id="accordion-collapse-heading-21">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-21" aria-expanded="false"
                        aria-controls="accordion-collapse-body-21">
                        <span>2.1 Requisitos generales</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-21" class="hidden" aria-labelledby="accordion-collapse-heading-21"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-3">
                                    <x-input wire:model="puesto.requisitos.edad" label="Edad" />
                                </div>
                                <div class="col-md-3">
                                    <x-select label="Género" :options="['Indistinto', 'Hombre', 'Mujer']"
                                        wire:model="puesto.requisitos.genero" />
                                </div>
                                <div class="col-md-3">
                                    <x-input wire:model="puesto.requisitos.educacion"
                                        label="Educación académica" />
                                </div>
                                <div class="col-md-3">
                                    <x-select label="Experiencia Mínima" :options="[
                                        'No requiere experiencia',
                                        '6 meses',
                                        '1 año',
                                        '2 años',
                                        '3 años',
                                        '4 años',
                                        '5 años',
                                        '6 años',
                                        '7 años',
                                        '8 años',
                                        '9 años',
                                        '10 años',
                                    ]"
                                        wire:model="puesto.requisitos.experiencia" />
                                </div>
                                <div class="col-md-12">
                                    <x-input wire:model="puesto.requisitos.tipo_experiencia"
                                        label="Tipo de compañía donde se desea experiencia" />
                                </div>
                                <div class="col-md-12">
                                    <x-input wire:model="puesto.requisitos.cursos"
                                        label="Cursos o certificaciones especiales" />
                                </div>
                                <div class="col-md-12">
                                    <x-input wire:model="puesto.requisitos.herramientas"
                                        label="Herramientas de trabajo" />
                                </div>
                                <div class="col-md-12">
                                    <x-input wire:model="puesto.requisitos.maquinaria"
                                        label="Manejo de maquinaria y equipo especializado" />
                                </div>
                                <div class="col-md-12">
                                    <x-input wire:model="puesto.requisitos.condiciones_especiales"
                                        label="Condiciones especiales de puesto" />
                                </div>
                            </div>
                            <hr class="my-3 col">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Conocimientos</p>
                                    @if (!$conocimientos->isEmpty())
                                        <ol class="list-group list-group-numbered">
                                            @foreach ($conocimientos as $index => $item)
                                                <li class="list-group-item">
                                                    <x-input
                                                        wire:model="conocimientos.{{ $index }}.descripcion" />
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_2_1"  spinner="guardar_2_1" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>
                {{-- 2.2 --}}
                <h5 id="accordion-collapse-heading-22">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-22" aria-expanded="false"
                        aria-controls="accordion-collapse-body-22">
                        <span> 2.2 Competencias</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-22" class="hidden" aria-labelledby="accordion-collapse-heading-22">
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Cardinales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Excelencia</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Compromiso</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Lealtad</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Confianza</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Técnica</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Liderazgo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Comunicacíon</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Enfoque a la calidad</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Enfoque a resultados</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>Trabajo en equipo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">6</th>
                                                <td>Pensamiento estratégico</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-card>
                    </div>
                </div>
                {{-- 2.3 --}}
                <h5 id="accordion-collapse-heading-23">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-23" aria-expanded="false"
                        aria-controls="accordion-collapse-body-23">
                        <span>2.3 Responsabilidades con los sistemas de gestión(calidad, seguridad, medio
                            ambiente, RSS y antisoborno)</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-23" class="hidden" aria-labelledby="accordion-collapse-heading-23"
                    wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-textarea label="Sistemas de Gestión"
                                        wire:model="puesto.responsabilidad_sgi" />
                                </div>
                            </div>
                            <x-slot name="footer">
                                <div class="flex justify-end">
                                    <x-button label="Guardar" primary wire:click="guardar_2_3"  spinner="guardar_2_3" loading-delay="short"/>
                                </div>
                            </x-slot>
                        </x-card>
                    </div>
                </div>

                {{-- Firmas --}}
                <h5 id="accordion-collapse-heading-21">
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-firma" aria-expanded="false"
                        aria-controls="accordion-collapse-body-firma">
                        <span>Firmas</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-collapse-body-firma" class="hidden"
                    aria-labelledby="accordion-collapse-heading-21" wire:ignore.self>
                    <div class="py-1">
                        <x-card>
                            <div class="row" x-data="{ isUploading: false, progress: 0, showBtn: true }"
                                x-on:livewire-upload-start="isUploading = true,showBtn=false"
                                x-on:livewire-upload-finish="isUploading = false,showBtn=true"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="col-md-6" wire:loading.class='disabled'
                                    wire:target="guardarFirmaElaboro">
                                    <div class="mb-3">
                                        <x-select label="Elaboro" :options="$users" option-label="first_name"
                                            option-description="last_name" option-value="id"
                                            wire:model="userElaboro" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Subir firma</label>
                                        <input class="form-control" type="file" wire:model.live='firmaElaboro'>
                                        <x-forms.error_message_livewire model="firmaElaboro">
                                        </x-forms.error_message_livewire>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div x-cloak x-show="isUploading" x-transition class="my-3 progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            x-bind:style="`width:${progress}%`" aria-valuenow="75" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div class="my-3" x-show="showBtn" x-transition>
                                        <x-button icon="document-add" wire:click="guardarFirmaElaboro" green
                                            label="Guardar imagen" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!$imgElaboro->isEmpty())
                                        <div
                                            class="border rounded border-light d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $imgElaboro[0]->getUrl('thumb') }}" class="img-fluid">
                                            <strong>{{ $imgElaboro[0]->name }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row" x-data="{ isUploading: false, progress: 0, showBtn: true }"
                                x-on:livewire-upload-start="isUploading = true,showBtn=false"
                                x-on:livewire-upload-finish="isUploading = false,showBtn=true"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="col-md-6" wire:loading.class='disabled' wire:target="guardarFirmaReviso">
                                    <div class="mb-3">
                                        <x-select label="Reviso" :options="$users" option-label="first_name"
                                            option-description="last_name" option-value="id"
                                            wire:model="userReviso" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Subir firma</label>
                                        <input class="form-control" type="file" wire:model.live='firmaReviso'>
                                        <x-forms.error_message_livewire model="firmaReviso">
                                        </x-forms.error_message_livewire>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div x-cloak x-show="isUploading" x-transition class="my-3 progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            x-bind:style="`width:${progress}%`" aria-valuenow="75" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div class="my-3" x-show="showBtn" x-transition>
                                        <x-button icon="document-add" wire:click="guardarFirmaReviso" green
                                            label="Guardar imagen" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!$imgReviso->isEmpty())
                                        <div
                                            class="border rounded border-light d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $imgReviso[0]->getUrl('thumb') }}" class="img-fluid">
                                            <strong>{{ $imgReviso[0]->name }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row" x-data="{ isUploading: false, progress: 0, showBtn: true }"
                                x-on:livewire-upload-start="isUploading = true,showBtn=false"
                                x-on:livewire-upload-finish="isUploading = false,showBtn=true"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="col-md-6" wire:loading.class='disabled'
                                    wire:target="guardarFirmaAutorizo">
                                    <div class="mb-3">
                                        <x-select label="Autorizo" :options="$users" option-label="first_name"
                                            option-description="last_name" option-value="id"
                                            wire:model="userAutorizo" />
                                    </div>
                                    <!-- Progress Bar -->
                                    <div x-cloak x-show="isUploading" x-transition class="my-3 progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            x-bind:style="`width:${progress}%`" aria-valuenow="75" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Subir firma</label>
                                        <input class="form-control" type="file" wire:model.live='firmaAutorizo'>
                                        <x-forms.error_message_livewire model="firmaAutorizo">
                                        </x-forms.error_message_livewire>
                                    </div>
                                    <div class="my-3" x-show="showBtn" x-transition>
                                        <x-button icon="document-add" wire:click="guardarFirmaAutorizo" green
                                            label="Guardar imagen" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!$imgAutorizo->isEmpty())
                                        <div
                                            class="border rounded border-light d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $imgAutorizo[0]->getUrl('thumb') }}" class="img-fluid">
                                            <strong>{{ $imgAutorizo[0]->name }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
