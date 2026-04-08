<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a class="active" href="{{ route('puestos.index') }}">Puestos</a>
            </li>
            <li class="breadcrumb-item active">
                <a class="active" href="{{ route('puestos.show', $puesto) }}"> {{ $puesto->name }}</a>
            </li>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Editar información del puesto</h2>
        </div>
    </div>
</div>
