<html>

<head>
    <meta name="author" content="GPT Services">
    <title>Descriptivo de puesto</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_puesto.css') }}">

</head>

<body class="pdf-body">
    <header id="pdf-header">
        <table class="table p-0 table-sm table-bordered">
            <tr class="p-0 text-center">
                <th scope="col" rowspan="4" style="vertical-align:middle; padding:0; width: 140px;"><img
                        src="https://res.cloudinary.com/gpt-services/image/upload/v1653666316/logos/logotipo_GPT_kzifqo.png"
                        alt="Brand" width="120" /></th>
                <th scope="col" colspan="6" class="p-0" style="color:#1f4e79;"> <small><b>TECH ENERGY CONTROL
                            S.A DE C.V</b></small> </th>
            </tr>
            <tr class="p-0 text-center">
                <th scope="col" colspan="6" class="p-0 mt-1"> <small><b>DESCRIPTIVO DE PUESTO (DDP)</b></small>
                </th>
            </tr>
            <tr class="text-center">
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>TIPO DE
                            DOCUMENTO</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 80px;">
                    <small><b>REVISIÓN</b></small>
                </th>
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>FECHA DE
                            APROBACIÓN</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>DEPARTAMENTO</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 130px;">
                    <small><b>CÓDIGO</b></small>
                </th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 80px;">
                    <small><b>PÁGINA</b></small>
                </th>
            </tr>
            <tr class="text-center">
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Formato</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>02</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Jun 22</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Recursos Humanos</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>FO-GPT-RH-01-B</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>&nbsp;</small></td>
            </tr>
        </table>
    </header>
    <footer id="pdf-footer">
        <table class="table p-0 table-sm">
            <tr>
                <td width="80%" style="background-color: #5b5a5f; color: #ffffff;">
                    <p class="m-0 font-weight-bold font-italic">TECH ENERGY CONTROL, S.A. DE C.V.</p>
                    <p class="m-0 small">Av. Santa M&oacute;nica 33, Col. El Mirador, C.P. 54080, Tlalnepantla de
                        Baz, Estado de M&eacute;xico, M&eacute;xico.</p>
                    <p class="m-0 small" style="margin-bottom: .6rem;">
                        www.gptservices.com&nbsp;&nbsp;|&nbsp;&nbsp;direccioncomercial@gptservices.com</p>
                </td>
                <td align="center" width="20%" style="background-color: #000000;vertical-align:middle;">
                    <img src="https://res.cloudinary.com/gpt-services/image/upload/v1647625668/logogw_a4qfvs.png"
                        width="92%" />
                </td>
            </tr>
        </table>
    </footer>
    <main>
        <p class="my-3 text-center w-100 font-weight-bold">1. DESCRIPCIÓN</p>
        <table class="table mb-4 w-100 table-sm">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="3" class="p-1">1.1 IDENTIFICACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-1">Nombre del Puesto/Rol:<div class="form-control">{{ $puesto->name }}
                        </div>
                    </td>
                    <td class="p-1">Área a la que pertenece:<div class="form-control">
                            {{ $puesto->departamento->area->name }}</div>
                    </td>
                    <td class="p-1">Departamento al que pertenece:<div class="form-control">
                            {{ $puesto->departamento->name }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table py-3 mt-2 w-100 table-sm">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="p-1">1.2 OBJETIVO PRINCIPAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-1">Objetivo general del puesto, contribución de acuerdo a los objetivos
                        estratégicos de la Dirección General
                        <div class="form-control">{{ $puesto->objetivo }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table pb-1 w-100 table-sm">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="5" class="p-1">1.3 FUNCIONES Y RESPONSABILIDADES</th>
                </tr>
                <tr class="table-active">
                    <th scope="col" colspan="5" class="p-1">RESPONSABILIDADES <br> <small>Toma de
                            decisiones.</small> </th>
                </tr>
                <tr>
                    <th scope="col" width="10%" class="text-center">#</th>
                    <th scope="col">Responsabilidad</th>
                    <th scope="col" class="text-center">Total</th>
                    <th scope="col" class="text-center">Compartida</th>
                    <th scope="col">Con</th>
                </tr>
            </thead>
            <tbody>
                @isset($puesto->responsabilidad)
                    @foreach ($puesto->responsabilidad as $responsabilidad)
                        <tr>
                            <th scope="row" class="text-center" style="vertical-align:middle;">{{ $loop->iteration }}
                            </th>
                            <td style="vertical-align:middle;">
                                <div class="form-control">{{ $responsabilidad['nombre'] }}</div>
                            </td>
                            @if ($responsabilidad['tipo'] == 'total')
                                <td width="100px" align="center" class="text-center" style="vertical-align:middle;">
                                    <img src="{{ asset('assets/images/puesto/c-cheque.png') }}" width="16"
                                        height="16">
                                </td>
                                <td width="100px" align="center" class="text-center" style="vertical-align:middle;">
                                    <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16"
                                        height="16">
                                </td>
                            @else
                                <td width="100px" align="center" class="text-center" style="vertical-align:middle;">
                                    <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16"
                                        height="16">
                                </td>
                                <td width="100px" align="center" class="text-center" style="vertical-align:middle;">
                                    <img src="{{ asset('assets/images/puesto/c-cheque.png') }}" width="16"
                                        height="16">
                                </td>
                            @endif
                            <td width="130px" style="vertical-align:middle;">
                                <div class="form-control">
                                    @empty($responsabilidad['compartida_con'])
                                        &nbsp;
                                    @else
                                        {{ $responsabilidad['compartida_con'] }}
                                    @endempty
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-active">
                    <th scope="col" colspan="2" class="p-1">FUNCIONES<br>
                        <small>Conjunto de actividades esenciales del trabajo.</small>
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="text-center" width="10%">#</th>
                    <th scope="col">Función</th>
                </tr>
            </thead>
            <tbody>
                @isset($puesto->funciones)
                    @foreach ($puesto->funciones as $funcion)
                        <tr>
                            <th scope="row" class="text-center" style="vertical-align:middle;">{{ $loop->iteration }}
                            </th>
                            <td style="vertical-align:middle;">
                                <div class="form-control">{{ $funcion }}</div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-active">
                    <th scope="col" colspan="2" class="p-1">AUTORIDAD Y RESPONSABILIDAD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:middle;" class="w-100">
                        <p>
                            Todos los colaboradores de GPT Services® son responsables de su seguridad personal, la de
                            sus
                            compañeros de trabajo y de la protección al medio ambiente.
                        </p>
                        <p>
                            Todos los colaboradores de GPT Services® tienen la autoridad para detener cualquier
                            actividad si
                            observan algún incumplimiento en los procedimientos, lineamientos, requerimientos y/o
                            políticas
                            en materia de Salud, Seguridad y protección al medio ambiente.
                        </p>
                        <p>
                            Todos los colaboradores de GPT Services® tiene la responsabilidad de notificar
                            inmediatamente a
                            su jefe directo, QHSE o RRHH las condiciones y/o actos inseguros que detecten en sus
                            actividades
                            diarias con el fin de prevenir accidentes, salvaguardar su integridad, preservar el equipo,
                            maquinaria y materiales de la empresa y/o evitar daños al medio ambiente.
                        </p>
                        <p>Todos los colaboradores de GPT Services tienen la autoridad para tomar decisiones
                            relacionadas con sus actividades vinculadas al SGI, tales como sugerir la actualización o
                            modificación de documentos y procesos de su área, con el fin de materializar oportunidades
                            de mejora y optimizar dichos procesos. Este listado es enunciativo, no limitativo. Para
                            conocer el detalle las autoridades asignadas, consulte los procedimientos del área."</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="3" class="p-1">1.4 CLASIFICACIÓN DEL PUESTO</th>
                </tr>
            </thead>
            <tbody>
                @switch($puesto->clasificacion)
                    @case('Operativo')
                        <tr>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-cheque.png') }}" width="16" height="16">
                                OPERATIVO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                TÁCTICO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                ESTRÁTEGICO
                            </td>
                        </tr>
                    @break

                    @case('Táctico')
                        <tr>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                OPERATIVO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-cheque.png') }}" width="16" height="16">
                                TÁCTICO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                ESTRÁTEGICO
                            </td>
                        </tr>
                    @break

                    @case('Estrátegico')
                        <tr>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                OPERATIVO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-uncheque.png') }}" width="16" height="16">
                                TÁCTICO
                            </td>
                            <td align="center" class="px-1 py-2 text-center" style="vertical-align:middle;">
                                <img src="{{ asset('assets/images/puesto/c-cheque.png') }}" width="16" height="16">
                                ESTRÁTEGICO
                            </td>
                        </tr>
                    @break
                @endswitch
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="3" class="p-1">1.5 COORDINACIÓN Y RELACIONES INTERNAS</th>
                </tr>
                <tr>
                    <th scope="col" width="10%" class="p-1 text-center">#</th>
                    <th scope="col" class="p-1">Coordina con</th>
                    <th scope="col" class="p-1">Departamento</th>
                </tr>
            </thead>
            <tbody>
                @isset($puesto->relaciones_internas)
                    @foreach ($puesto->relaciones_internas as $relacion)
                        <tr>
                            <th scope="row" class="p-1 text-center" style="vertical-align:middle;">
                                {{ $loop->iteration }}
                            </th>
                            <td class="p-1" style="vertical-align:middle;">
                                <div class="form-control">{{ $relacion['depto'] }}</div>
                            </td>
                            <td class="p-1" style="vertical-align:middle;">
                                <div class="form-control">{{ $relacion['actividad'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="3" class="p-1">1.6 COORDINACIÓN Y RELACIONES EXTERNAS</th>
                </tr>
                <tr>
                    <th scope="col" width="10%" class="p-1 text-center">#</th>
                    <th scope="col" class="p-1">Empresa o dependencia</th>
                    <th scope="col" class="p-1">Motivo</th>
                </tr>
            </thead>
            <tbody>
                @isset($puesto->relaciones_externas)
                    @foreach ($puesto->relaciones_externas as $relacion)
                        <tr>
                            <th scope="row" class="p-1 text-center" style="vertical-align:middle;">
                                {{ $loop->iteration }}
                            </th>
                            <td class="p-1" style="vertical-align:middle;">
                                <div class="form-control">{{ $relacion['empresa'] }}</div>
                            </td>
                            <td class="p-1" style="vertical-align:middle;">
                                <div class="form-control">{{ $relacion['motivo'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="3" class="p-1">1.7 PERSONAL A CARGO</th>
                </tr>
                <tr>
                    <th scope="col" width="10%" class="p-1 text-center">#</th>
                    <th scope="col" class="p-1">Puesto a cargo</th>
                    <th scope="col" class="p-1">Actividad supervisada</th>
                </tr>
            </thead>
            <tbody>
                @if ($puesto->personal_cargo)
                    @foreach ($puesto->personal_cargo as $personal)
                        <tr>
                            <th scope="row" class="p-1 text-center" style="vertical-align:middle;">
                                {{ $loop->iteration }}</th>
                            <td class="p-1" style="vertical-align:middle;">
                                {{ $personal['puesto'] }}
                            </td>
                            <td class="p-1" style="vertical-align:middle;">
                                <div class="form-control">{{ $personal['actividad'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th scope="col" colspan="3" class="p-1">
                            <div class="form-control">&nbsp;</div>
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="p-1" colspan="2">1.8 PLAN DE CONTINGENCIA (EN CASO DE AUSENCIA)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="p-1" width="100%">Reemplaza a:<br><small>(Plan de contingencia
                            cubre a)</small></th>
                </tr>
                @isset($puesto->plan_contingencia)
                    <tr>
                        <td class="p-1" style="vertical-align:middle;" width="50%">
                            <div class="form-control">{{ $puesto->plan_contingencia['reemplaza'] }}</div>
                        </td>
                    </tr>
                @endisset
                <tr>
                    <th scope="col" class="p-1" width="100%">Es reemplazado por: <br> <small>(Plan de
                            contingencia en caso de ausencia)</th>
                </tr>
                @isset($puesto->plan_contingencia)
                    <tr>
                        <td class="p-1" style="vertical-align:middle;" width="50%">
                            <div class="form-control">{{ $puesto->plan_contingencia['reemplazo'] }}</div>
                        </td>
                    </tr>
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="p-1" colspan="2">1.9 DESARROLLO</th>
                </tr>
                <tr>
                    <th scope="col" class="p-1" width="50%">Qué posición se tiene lista para crecimiento a
                        esta posición:</th>
                    <th scope="col" class="p-1" width="50%">Siguiente puesto a ocupar:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-1" style="vertical-align:middle;" width="50%">
                        @isset($puesto->desarrollo['a'])
                            <div class="form-control">{{ $puesto->desarrollo['a'] }}</div>
                        @endisset
                    </td>
                    <td class="p-1" style="vertical-align:middle;" width="50%">
                        @isset($puesto->desarrollo['b'])
                            <div class="form-control">{{ $puesto->desarrollo['b'] }}</div>
                        @endisset
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm table-striped page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="p-1" colspan="2">1.10 AMBIENTE PARA LA OPERACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" class="p-1" style="vertical-align:middle;" width="30%">Lugar físico de
                        trabajo:</th>
                    <td class="p-1" style="vertical-align:middle;" width="70%">
                        <div class="form-control">
                            @isset($puesto->ambiente['lugar_trabajo'])
                                {{ $puesto->ambiente['lugar_trabajo'] }}
                            @endisset
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="p-1" style="vertical-align:middle;" width="30%">Equipo de
                        seguridad:</th>
                    <td class="p-1" style="vertical-align:middle;" width="70%">
                        <div class="form-control">Consultar matriz EPP</div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="p-1" style="vertical-align:middle;" width="30%">Días de trabajo:
                    </th>
                    <td class="p-1" style="vertical-align:middle;" width="70%">
                        <div class="form-control">
                            @isset($puesto->ambiente['lunes'])
                                @if ($puesto->ambiente['lunes'])
                                    Lunes
                                @endif
                            @endisset

                            @isset($puesto->ambiente['martes'])
                                @if ($puesto->ambiente['martes'])
                                    , Martes
                                @endif
                            @endisset

                            @isset($puesto->ambiente['miercoles'])
                                @if ($puesto->ambiente['miercoles'])
                                    , Miercoles
                                @endif
                            @endisset

                            @isset($puesto->ambiente['jueves'])
                                @if ($puesto->ambiente['jueves'])
                                    , Jueves
                                @endif
                            @endisset

                            @isset($puesto->ambiente['viernes'])
                                @if ($puesto->ambiente['viernes'])
                                    , Viernes
                                @endif
                            @endisset

                            @isset($puesto->ambiente['sabado'])
                                @if ($puesto->ambiente['sabado'])
                                    , Sabado
                                @endif
                            @endisset

                            @isset($puesto->ambiente['domingo'])
                                @if ($puesto->ambiente['domingo'])
                                    , Domingo
                                @endif
                            @endisset
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="p-1" style="vertical-align:middle;" width="30%">Jornada de
                        trabajo:</th>
                    <td class="p-1" style="vertical-align:middle;" width="70%">
                        @isset($puesto->ambiente['horario_trabajo'])
                            <div class="form-control">{{ $puesto->ambiente['horario_trabajo'] }}</div>
                        @endisset
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="p-1" style="vertical-align:middle;" width="30%">Tiempo de
                        comida:
                    </th>
                    <td class="p-1" style="vertical-align:middle;" width="70%">
                        @isset($puesto->ambiente['tiempo_comida'])
                            <div class="form-control">{{ $puesto->ambiente['tiempo_comida'] }}</div>
                        @endisset
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="page-break-inside">
            <p class="pt-3 mb-3 text-center w-100 font-weight-bold">2. PERFIL DEL PUESTO</p>
            <table class="table pb-3 w-100 table-sm table-striped">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col" colspan="2" class="p-1">2.1 REQUISITO GENERALES</th>
                    </tr>
                    <tr class="table-secondary">
                        <th scope="col" class="p-1 w-35">
                            <p class="mb-0 text-break">Requisitos</p>
                        </th>
                        <th scope="col" class="p-1 ">
                            <p class="mb-0 text-break">Descripción</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Edad</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['edad'])
                                    {{ $puesto->requisitos['edad'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Género</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            @isset($puesto->requisitos['genero'])
                                <div class="form-control">{{ $puesto->requisitos['genero'] }}</div>
                            @endisset
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Educación&nbsp;académica</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['educacion'])
                                    {{ $puesto->requisitos['educacion'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Experiencia mínima</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['experiencia'])
                                    {{ $puesto->requisitos['experiencia'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Tipo de compañía&nbsp; donde se desea experiencia</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['tipo_experiencia'])
                                    {{ $puesto->requisitos['tipo_experiencia'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Cursos&nbsp;o&nbsp;certificaciones&nbsp;especiales</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['cursos'])
                                    {{ $puesto->requisitos['cursos'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Herramientas de trabajo</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['herramientas'])
                                    {{ $puesto->requisitos['herramientas'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Manejo de maquinaria y equipo especializado</p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['maquinaria'])
                                    {{ $puesto->requisitos['maquinaria'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="p-1 w-35" style="vertical-align:middle;">
                            <p class="text-break">Condiciones especiales de puesto <br> <small>(viajes, home
                                    office, cambio de residencia horario, herramientas de trabajo que requiere)</small>
                            </p>
                        </th>
                        <td class="p-1 " style="vertical-align:middle;">
                            <div class="form-control">
                                @isset($puesto->requisitos['condiciones_especiales'])
                                    {{ $puesto->requisitos['condiciones_especiales'] }}
                                @endisset
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="table py-3 w-100 table-sm table-striped page-break-inside">
            <thead>
                <tr class="table-active">
                    <th scope="col" colspan="2" class="p-1">Conocimientos requeridos.</th>
                </tr>
                <tr>
                    <th scope="col" width="10%" class="text-center">#</th>
                    <th scope="col">Conocimiento</th>
                </tr>
            </thead>
            <tbody>
                @isset($puesto->conocimiento)
                    @foreach ($puesto->conocimiento as $skill)
                        <tr>
                            <th scope="row" width="10%" class="text-center" style="vertical-align:middle;">
                                {{ $loop->iteration }}</th>
                            <td style="vertical-align:middle;">
                                <div class="form-control">{{ $skill->descripcion }}</div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" colspan="2" class="p-1">2.2. COMPETENCIAS <br> <small
                            style="color:red;"> Consultar matriz de competencias.</small> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-0 w-50" width="50%">
                        <table class="table w-100 table-sm table-bordered">
                            <thead>
                                <tr class="table-active">
                                    <th scope="col" class="p-1 text-center">#</th>
                                    <th scope="col" class="p-1">Cardinales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">1</th>
                                    <td class="p-1" style="vertical-align:middle;">Excelencia</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">2</th>
                                    <td class="p-1" style="vertical-align:middle;">Compromiso</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">3</th>
                                    <td class="p-1" style="vertical-align:middle;">Lealtad</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">4</th>
                                    <td class="p-1" style="vertical-align:middle;">Confianza</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="p-0 w-50" width="50%">
                        <table class="table w-100 table-sm table-bordered">
                            <thead>
                                <tr class="table-active">
                                    <th scope="col" class="p-1 text-center">#</th>
                                    <th scope="col" class="p-1">Técnicas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">1</th>
                                    <td class="p-1" style="vertical-align:middle;">Liderazgo</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">2</th>
                                    <td class="p-1" style="vertical-align:middle;">Comunicación</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">3</th>
                                    <td class="p-1" style="vertical-align:middle;">Enfoque a la calidad</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">4</th>
                                    <td class="p-1" style="vertical-align:middle;">Enfoque a resultados</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">5</th>
                                    <td class="p-1" style="vertical-align:middle;">Trabajo en equipo</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1 text-center" style="vertical-align:middle;">6</th>
                                    <td class="p-1" style="vertical-align:middle;">Pensamiento estratégico
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table py-3 w-100 table-sm page-break-inside">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="p-1">2.3. RESPONSABILIDAD CON LOS SISTEMAS DE GESTIÓN <br>
                        <small>(CALIDAD, SEGURIDAD, SALUD, MEDIO AMBIENTE Y ANTISOBORNO)</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-1">Sistemas de Gestión<div class="form-control">
                            @isset($puesto->responsabilidad_sgi)
                                {{ $puesto->responsabilidad_sgi }}
                            @endisset
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-1">Perfil médico<div class="form-control">Consultar matriz, exámenes
                            médicos periódicos.</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="page-break-inside">
            <table class="table w-100 table-sm table-bordered">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col" class="p-1 text-center"><small><b>ELABORÓ</b></small></th>
                        <th scope="col" class="p-1 text-center"><small><b>REVISÓ</b></small></th>
                        <th scope="col" class="p-1 text-center"><small><b>AUTORIZÓ</b></small></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class='text-center'>
                            @if (!empty($imgElaboro))
                                <div class="container-firma">
                                    <img src="{{ $imgElaboro->getUrl('thumb') }}" style="width:4cm;height:4cm;"
                                        class="imagen-fondo-firma">
                                    <span class="texto-firma"> {{ $imgElaboro->getCustomProperty('nombre') }}</span>
                                </div>
                            @endif
                        </td>
                        <td class='text-center'>
                            @if (!empty($imgReviso))
                                <div class="container-firma">
                                    <img src="{{ $imgReviso->getUrl('thumb') }}" style="width:4cm;height:4cm;"
                                        class="imagen-fondo-firma">
                                    <span class="texto-firma"> {{ $imgReviso->getCustomProperty('nombre') }}</span>
                                </div>
                            @endif
                        </td>
                        <td class='text-center'>
                            @if (!empty($imgAutorizo))
                                <div class="container-firma">
                                    <img src="{{ $imgAutorizo->getUrl('thumb') }}" style="width:4cm;height:4cm;"
                                        class="imagen-fondo-firma">
                                    <span class="texto-firma"> {{ $imgAutorizo->getCustomProperty('nombre') }}</span>
                                </div>
                            @endif
                        </td>

                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td class="pt-5 text-center" style="vertical-align:middle;">
                            @if (filled($firmas['solicita']))
                                {{ $firmas['solicita']->job->departamento->name }}
                            @endif
                        </td>
                        <td class='pt-5 text-center' style='vertical-align:middle;'>
                             @if (filled($firmas['reviso']))
                                {{ $firmas['reviso']->job->departamento->name }}
                            @endif
                        </td>
                        <td class='pt-5 text-center' style='vertical-align:middle;'>
                            @if (filled($firmas['autorizo']))
                                {{ $firmas['autorizo']->job->departamento->name }}
                            @endif
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>

        <script type="text/php">
            if (isset($pdf)) {
                        $x = 528;
                        $y = 112;
                        $text = "{PAGE_NUM} de {PAGE_COUNT}";
                        $font = "Source Sans Pro, open sans";
                        $size = 9;
                        $color = array(0,0,0);
                        $word_space = 0.0;  //  default
                        $char_space = 0.0;  //  default
                        $angle = 0.0;   //  default
                        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                        }
                        </script>
    </main>
</body>

</html>
