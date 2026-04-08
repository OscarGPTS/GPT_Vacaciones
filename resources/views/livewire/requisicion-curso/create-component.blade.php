<div>
    <div class="row">
        <div class="col-md-12">
            <x-card title="Nueva solicitud">
                <form>
                    <div class="row">
                        <div class="col">
                            <x-input wire:model="nombreCurso" label="Nombre del curso" />
                        </div>
                        <div class="col">
                            <x-select label="Tipo de capacitación" :options="['Curso', 'Seminario', 'Diplomado', 'Otro']"
                                wire:model="tipoCapacitacion" />
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col">
                            <x-select label="Participantes: si el curso es dirigido a más colaboradores"
                                :options="$users" multiselect option-label="first_name" option-value="id"
                                option-description="last_name" wire:model="participantes" />
                        </div>
                        <div class="col">
                            <x-select label="Motivo: Identificar vínculo de requerimiento" :options="[
                                'Actualizaciones / Nuevas herramientas o tecnologías',
                                'Cumplimiento normativo',
                                'Resultados de evaluación de competencia',
                                'Sistema de Gestión Integral',
                                'Solicitud de curso (Internas ó Externas)',
                            ]"
                                wire:model="motivo" />
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-md-12">
                            <x-textarea label="Justificación" wire:model="justificacion" maxlength="700"
                                rows="4" />
                        </div>

                        <div class="col-md-12">
                            <x-textarea label="Beneficio" wire:model="beneficio" maxlength="700" rows="4" />
                        </div>
                        <div class="col-md-12">
                            <x-textarea label="Comentarios" wire:model="comentarios" maxlength="700"
                                rows="4" />
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row" x-data="{ cotizacion: @entangle('cotizacion').live }">
                        <div class="col-md-4">
                            <x-select label="¿Cuentas con alguna propuesta y/o cotización?" :options="['Si', 'No']"
                                wire:model.live="cotizacion" clearable="false" />
                        </div>
                        <div class="col-md-8" x-show="cotizacion == 'Si'" x-transition>
                            <div>
                                <x-errors only="cotizacionFile|temarioFile" />
                            </div>
                            <div>
                                <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 1Mb.</span>
                                <p>Cargar PDF de cotización</p>
                                <x-forms.input-filepond wire:model.live="cotizacionFile" accept="application/pdf" maxFileSize="1MB" />
                            </div>
                            <div>
                                <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 1MB.</span>
                                <p>Cargar PDF de temario</p>
                                <x-forms.input-filepond wire:model.live="temarioFile" accept="application/pdf" maxFileSize="1MB" />
                            </div>
                        </div>
                    </div>
                </form>
                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <x-button label="Guardar" positive spinner="guardar" loading-delay="short"
                            wire:click="guardar" />
                    </div>
                </x-slot>
            </x-card>
        </div>
    </div>
</div>
