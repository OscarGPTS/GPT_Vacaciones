<div>
    <x-button label="Cargar cursos" icon="table" primary onclick="$openModal('excelCursosModal')" />
    {{-- Modal para cargar los cursos y certificaciones desde un Excel --}}
    <x-modal.card title="Cargar Excel" blur wire:model="excelCursosModal">
        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading=true"
            x-on:livewire-upload-finish="isUploading=false" x-on:livewire-upload-error="isUploading=false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <div class="m-2">
                <strong class="text-red-600">NOTA:</strong> <span class="text-justify text-gray-500 dark:text-gray-400">El Excel solo debe contener 3 columnas, columna id que debe ser numérico, columna tema y columna fecha 

                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left text-gray-500 border border-gray-700 rounded-lg dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    id
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    tema
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    fecha
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    1234
                                </th>
                                <td class="px-6 py-4">
                                    Lorem ipsum dolor sit amet!
                                </td>
                                <td class="px-6 py-4">
                                    26 de enero de 2023
                                </td>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="m-2">
                <x-errors />
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="small_size">Cargar
                    Excel</label>
                <input
                    class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="small_size" type="file" wire:model.live="file">
            </div>
            <div x-cloak x-show="isUploading" x-transition class="mt-2 progress">
                <div class="progress-bar bg-success" role="progressbar" x-bind:style="`width:${progress}%`"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat negative label="Cancelar" x-on:click="close" />
                <x-button positive label="Guardar" wire:click="guardar" spinner="guardar" loading-delay="short" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
