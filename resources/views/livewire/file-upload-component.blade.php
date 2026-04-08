<div>
    @pushOnce('css')
        <link rel="stylesheet" href="{{ asset('css/filepond.css') }}">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
            rel="stylesheet" />
    @endPushOnce
    <div>
        <x-errors only="fileName|newFile" />
    </div>
    <div wire:ignore x-data x-init="() => {
        const post = FilePond.create($refs.input);
        post.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('newFile', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('newFile', filename, load)
                },
            }
        });
        Livewire.on('resetFilePond', () => {
            resetFilePond();
        });
        // Agregamos la función para resetear FilePond
        window.resetFilePond = () => {
            post.removeFiles();
        };
    }">
        <form>
            <input type="file" x-ref="input" wire:model.live="newFile" />
            <div class="mb-2">
                <x-input label="Nombre del archivo" wire:model.live='fileName' maxlength="100" />
            </div>
        </form>
        <div>
            <x-button wire:click="guardar" spinner="guardar" loading-delay="short" positive label="Guardar" />
        </div>
    </div>
    {{-- Lista de archivos --}}
    <hr class="my-4">
    <div class="row">
        <div class="col-md-12">
            @if (filled($this->files))
                <ul class="mb-4 space-y-3">
                    @foreach ($this->files as $key => $file)
                        <li>
                            <div
                                class="flex items-center p-2 text-base font-bold text-gray-900 rounded-lg bg-gray-200 hover:bg-gray-300 group hover:shadow">
                                <a href="{{ $file->getUrl() }}" target="_blank" class="flex flex-1">
                                    <x-icon name="photograph" class="w-5 h-5" />
                                    <span class="flex-1 ms-3 whitespace-nowrap">{{ $file->name }}</span>
                                </a>
                                <x-button.circle flat negative class="w-3 h-3" icon="x"
                                    wire:click="deleteFileDB('{{ $key }}')"
                                    spinner="deleteFileDB('{{ $key }}')" />
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @pushOnce('scripts')
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="{{ asset('js/filepond.js') }}"></script>
        <script>
            // Set default FilePond options
            // Register the plugin
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.setOptions({
                server: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                }
            });
        </script>
    @endPushOnce
</div>
