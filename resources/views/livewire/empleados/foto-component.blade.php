<div>
    @push('scripts')
        @filepondScripts
    @endpush
    <div class="row">
        <div class="col-lg-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.index') }}">Lista de empleados</a>
                </li>
                <li class="breadcrumb-item">Empleado</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.show', $empleado->id) }}">{{ $empleado->id }}</a>
                </li>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-card title="Foto del colaborador">
                <img src="{{ $empleado->profile_image }}" class="rounded w-36 h-36" alt="">
            </x-card>
        </div>
        <div class="col-md-6">
            <x-card title="Cambiar foto del colaborador">
                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading=true"
                    x-on:livewire-upload-finish="isUploading=false" x-on:livewire-upload-error="isUploading=false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div wire:loading.class='disabled' wire:target="guardar">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Subir archivo</label>
                                <input class="form-control" type="file" wire:model.live='foto'>
                                @error('foto')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div x-cloak x-show="isUploading" x-transition class="mt-2 progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    x-bind:style="`width:${progress}%`" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <x-button label="Guardar" positive wire:click="guardar" spinner="guardar"
                            loading-delay="short" />
                    </div>
                </x-slot>
            </x-card>
        </div>
        {{-- <div class="col-md-6">
            <x-card title="Cambiar foto del colaborador">
                <div class="mb-2">
                    <x-filepond::upload wire:model="foto" />
                </div>
                @error('foto')
                    <span class="error">{{ $message }}</span>
                @enderror
                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <x-button label="Guardar" positive wire:click="guardarLocal" spinner="guardarLocal"
                            loading-delay="short" />
                    </div>
                </x-slot>
            </x-card>
        </div> --}}
    </div>
</div>
