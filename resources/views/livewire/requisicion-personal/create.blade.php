 <div class="row">
     <div class="col-lg-12" x-data="{ motivo: @entangle('rq.motivo').live }">
         <x-card>
             <form>
                 <div class="row">
                     <div class="col-md-4">
                         <x-select label="Tipo de personal" :options="['Administrativo', 'Operativo']" wire:model.live.="rq.tipo_personal" />
                     </div>
                     <div class="col-md-4">
                         <x-select label="Motivo de la requisición" :options="['Baja', 'Reemplazo', 'Incremento de actividad', 'Nueva creación']" wire:model.live="rq.motivo" />
                     </div>
                     <div class="col-md-4">
                         <x-select label="Último grado de estudios" :options="[
                             'Primaria',
                             'Secundaria',
                             'Preparatoria',
                             'Licenciatura',
                             'Licenciatura en proceso últimos semestres',
                             'Maestria',
                             'Doctorado',
                         ]"
                             wire:model.live="rq.grado_escolar" />
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-4">
                         <x-select label="Años de experiencia" :options="['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10']"
                             wire:model.live="rq.experiencia_years" />
                     </div>
                     <div class="col-md-4">
                         <x-select label="Personas requeridas" :options="['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']"
                             wire:model.live="rq.personas_requeridas" />
                     </div>
                     <div class="col-md-4">
                         <x-select label="Horario" :options="['7:30 - 15:00', '8:30 - 17:30', '8:00 - 14:00']" wire:model.live="rq.horario" />
                     </div>
                 </div>
                 <hr>
                 <div class="mt-3 row">
                     <div class="col-md-3">
                         <x-checkbox id="1" left-label="¿Realizará trabajo en campo?"
                             wire:model="rq.trabajo_campo" />
                     </div>
                     <div class="col-md-3">
                         <x-checkbox id="1"
                             left-label="¿Tendrá trato con clientes o
                        proveedores?"
                             wire:model="rq.trato_clientes" />
                     </div>
                     <div class="col-md-3">
                         <x-checkbox id="1"
                             left-label="¿Deberá tener la capacidad para el manejo de
                        personal?"
                             wire:model="rq.manejo_personal" />
                     </div>
                     <div class="col-md-3">
                         <x-checkbox id="1" left-label="¿Se requiere licencia de conducir?"
                             wire:model.live="rq.licencia_conducir" />
                         @if ($rq->licencia_conducir == true)
                            <x-input wire:model="rq.licencia_tipo"  label="Tipo de licencia"/>
                        @endif
                     </div>
                 </div>
                 <hr>
                 <div class="row">
                     <div class="col-md-12" x-show="motivo == 'Nueva creación'" x-transition>
                         <div class="p-4 shadow-sm b-r-8 b-light text-dark">
                             <div class="mb-3 row">
                                 <div class="col-md-6">
                                     <x-input wire:model.live="rq.puesto_nuevo" label="Nombre del puesto" />
                                 </div>
                             </div>
                             {{-- Conocimientos --}}
                             <div class="col-md-12">
                                 <h5 class="font-primary">Principales conocimientos</h5>
                                 <span>Ingresa los principales conocimientos que deberá poseer el
                                     candidato</span>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
                                         <thead>
                                             <tr>
                                                 <th width="10">#</th>
                                                 <th>Conocimiento</th>
                                                 <th>
                                                     <x-button.circle xs icon="plus" green
                                                         wire:click="addRow('conocimientos')" />
                                                 </th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($conocimientos as $conocimiento)
                                                 <tr>
                                                     <th class="w-10">{{ $loop->iteration }}</th>
                                                     <td>
                                                         <input type="text" class="form-control"
                                                             wire:model="conocimientos.{{ $loop->index }}"
                                                             maxlength="200">
                                                     </td>
                                                     <td>
                                                         <x-button.circle xs icon="trash" negative
                                                             wire:click="removeRow('conocimientos',{{ $loop->index }})" />
                                                     </td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @error('conocimientos.*')
                                     <small class="font-danger fw-bold">{{ $message }}</small>
                                 @enderror
                             </div>
                             {{-- Competencias --}}
                             <div class="col-md-12">
                                 <h5 class="font-primary">Competencias</h5>
                                 <span>Ingresa las competencias que deberá poseer el
                                     candidato</span>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
                                         <thead>
                                             <tr>
                                                 <th width="10">#</th>
                                                 <th>Competencia</th>
                                                 <th>
                                                     <x-button.circle xs icon="plus" green
                                                         wire:click="addRow('competencias')" />
                                                 </th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($competencias as $competencia)
                                                 <tr>
                                                     <th class="w-10">{{ $loop->iteration }}</th>
                                                     <td>
                                                         <input type="text" class="form-control"
                                                             wire:model="competencias.{{ $loop->index }}"
                                                             maxlength="200">
                                                     </td>
                                                     <td>
                                                         <x-button.circle xs icon="trash" negative
                                                             wire:click="removeRow('competencias',{{ $loop->index }})" />
                                                     </td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @error('competencias.*')
                                     <small class="font-danger fw-bold">{{ $message }}</small>
                                 @enderror
                             </div>
                             {{-- Actividades --}}
                             <div class="col-md-12">
                                 <h5 class="font-primary">Principales actividades</h5>
                                 <span>Ingresa las principales actividades que deberá realizar el
                                     candidato</span>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
                                         <thead>
                                             <tr>
                                                 <th width="10">#</th>
                                                 <th>Actividad</th>
                                                 <th>
                                                     <x-button.circle xs icon="plus" green
                                                         wire:click="addRow('actividades')" />
                                                 </th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($actividades as $actividad)
                                                 <tr>
                                                     <th class="w-10">{{ $loop->iteration }}</th>
                                                     <td>
                                                         <input type="text" class="form-control"
                                                             wire:model="actividades.{{ $loop->index }}"
                                                             maxlength="200">
                                                     </td>
                                                     <td>
                                                         <x-button.circle xs icon="trash" negative
                                                             wire:click="removeRow('actividades',{{ $loop->index }})" />
                                                     </td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @error('actividades.*')
                                     <small class="font-danger fw-bold">{{ $message }}</small>
                                 @enderror
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6" x-show="motivo !== 'Nueva creación'" x-transition>
                         <x-select label="Puesto Solicitado" :options="$puestos" option-label="name" option-value="id"
                             wire:model="rq.puesto_solicitado" />
                     </div>
                 </div>
             </form>
             <x-slot name="footer">
                 <div class="flex items-center justify-between">
                     <x-button label="Solicitar" positive wire:click="guardar"  spinner="guardar" loading-delay="short" />
                 </div>
             </x-slot>
         </x-card>
     </div>
 </div>
