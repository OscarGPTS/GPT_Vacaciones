@extends('authentication.master')

@section('title')
    Inicio de sesión
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="login-card">
                    <div class="shadow-lg theme-form login-form">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/images/logo/logo_GPT.svg') }}" alt="Logo de la empresa" class="img-fluid">
                        </div>
                        <h1 class="text-center f-w-600 font-warning">Recursos Humanos</h1>
                        <h2 class="text-center f-w-600 font-primary">¡BIENVENID@!</h2>
                        <div class="login-social-title">
                            <h5>
                                Si eres colaborador:
                            </h5>
                        </div>
                        <h6>Para continuar inicia sesión con tu cuenta de GPT SERVICES.</h6>
                        <div class="form-group">
                            <a href="{{ route('login.redirect') }}" class="btn btn-primary">
                                <i class="icofont icofont-social-google-plus"></i>
                                Inicia sesión con Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
