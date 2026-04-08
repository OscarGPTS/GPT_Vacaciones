@props(['maxFileSize' => '100KB'])
<div wire:ignore x-data x-init="() => {
    const post = FilePond.create($refs.input, {
        // Only accept images
        acceptedFileTypes: ['{!! isset($attributes['accept']) ? $attributes['accept'] : '' !!}'],
        maxFileSize: '{!! $maxFileSize !!}',
        labelMaxFileSizeExceeded: 'El archivo es demasiado grande',
        'labelMaxFileSize':'El tamaño máximo de archivo es  {filesize}'
    });
    post.setOptions({
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload('{{ $attributes['wire:model.live'] }}', file, load, error, progress)
            },
            revert: (filename, load) => {
                @this.removeUpload('{{ $attributes['wire:model.live'] }}', filename, load)
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
    @push('css')
    <link rel="stylesheet" href="{{ asset('css/filepond.css') }}">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    @endPush
    <div>
        <input type="file" name="{{ $attributes['wire:model.live'] }}" x-ref="input" />
    </div>
    <div>
        <x-forms.error_message_livewire model="{{ $attributes['wire:model.live'] }}"></x-forms.error_message_livewire>
    </div>
    @push('scripts')
    <script src="{{ asset('js/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js">
    </script>
    <script src="{{ asset('js/filepond.js') }}"></script>
    <script>
        // Set default FilePond options
            // Register the plugin
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.setOptions({
                server: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                }
            });

    </script>
    @endPush
</div>
{{-- {!! isset($attributes['accept']) ? 'accept="' . $attributes['accept'] . '"' : '' !!} --}}
