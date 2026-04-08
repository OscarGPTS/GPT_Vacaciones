@extends('layouts.codebase.master')
@section('content')
<div class="mb-2 row">
    <div class="col-md-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">Editar curriculum del colaborador</h4>
                <div class="flex-row gap-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <strong>{{ $user->nombre() }}</strong>
                        <small>{{ $user->job->name }}</small>
                    </div>
                    <x-button teal icon="document-text" spinner href="{{ route('perfil.cv.otros.pdf', $user) }}" />
                </div>
            </div>
        </x-card>
    </div>
</div>
@livewire('perfil.cv-component', ['otroCv' => true, 'user' => $user])
@endsection