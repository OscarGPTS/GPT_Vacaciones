@extends('layouts.codebase.master')
@section('content')
<div class="mb-2 row">
    <div class="col-md-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">Editar mi curriculum</h4>
                <div class="gap-1 d-flex align-content-stretch">
                    @can('editar otros cvs')
                    <x-button warning label="Editar otros CVS" href="{{ route('perfil.cv.editar.otros') }}" />
                    @endcan
                    <x-button teal icon="document-text" spinner href="{{ route('perfil.cv.pdf') }}" />
                </div>
            </div>
        </x-card>
    </div>
</div>
@livewire('perfil.cv-component')
@endsection