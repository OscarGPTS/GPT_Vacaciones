<div>
    <div wire:ignore x-data x-init="() => {
        const post = FilePond.create($refs.input, {
            // Only accept images
            acceptedFileTypes: ['{!! isset($attributes['accept']) ? $attributes['accept'] : '' !!}'],
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
        <input type="file" name="{{ $attributes['wire:model.live'] }}" x-ref="input" />
    </div>
</div>
{{-- {!! isset($attributes['accept']) ? 'accept="' . $attributes['accept'] . '"' : '' !!} --}}
