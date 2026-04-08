<div>
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    @endpush
    <div wire:ignore>
        <select class="form-select" wire:model.live="{{ $model }}" id="{{ $select }}">
            @foreach ($list as $value)
                <option value="{{ $value->id }}">{{ $value->$propiedad }}</option>
            @endforeach
        </select>
        <x-forms.error_message_livewire model="{{ $model }}"></x-forms.error_message_livewire>
    </div>
    {{-- Script para poder validar formularios --}}
    @push('scripts')
        <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#{{ $select }}').select2();
                $('#{{ $select }}').on('change', function (e) {
                    var data = $('#{{ $select }}').select2("val");
                    @this.set('{{ $model }}', data);
                });
            });
        </script>
    @endpush
</div>
