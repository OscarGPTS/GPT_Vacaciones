<div class="content-side content-side-full">
    <ul class="nav-main">

         {{-- Módulo de Administración - super-admin --}}
        @can('ver modulo rrhh')
            <li class="nav-main-heading">Administración</li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.index') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Roles y Permisos</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.manager-approvers.index') }}">
                    <i class="nav-main-link-icon fa fa-user-tie"></i>
                    <span class="nav-main-link-name">Jefes Directos</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.direction-approvers.index') }}">
                    <i class="nav-main-link-icon fa fa-user-shield"></i>
                    <span class="nav-main-link-name">Aprobadores Dirección</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.delegation-permissions.index') }}">
                    <i class="nav-main-link-icon fa fa-user-friends"></i>
                    <span class="nav-main-link-name">Permisos de Delegación</span>
                </a>
            </li>
            @if (auth()->user()->id == 333)
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/impersonate*') ? 'active' : '' }}" href="{{ route('admin.impersonate.index') }}">
                        <i class="nav-main-link-icon fa fa-user-secret"></i>
                        <span class="nav-main-link-name">Pruebas de Usuario</span>
                    </a>
                </li>
            @endif
            
            {{-- Prueba de Correo y Optimización ocultos --}}
            {{--
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.test-email') }}">
                    <i class="nav-main-link-icon fa fa-envelope-open-text"></i>
                    <span class="nav-main-link-name">Prueba de Correo</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.optimize') }}">
                    <i class="nav-main-link-icon fa fa-cogs"></i>
                    <span class="nav-main-link-name">Optimización</span>
                </a>
            </li>
            --}}
            <br>
        @endcan

        <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('organigrama.index') }}">
                <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                <span class="nav-main-link-name">Organigrama</span>
            </a>
        </li>

        {{-- Módulo de Vacaciones --}}
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                aria-expanded="false" href="#">
                <i class="nav-main-link-icon fa fa-calendar-check"></i>
                <span class="nav-main-link-name">Vacaciones</span>
                @if(isset($pendingManagerRequests) && $pendingManagerRequests > 0 || isset($pendingDirectionRequests) && $pendingDirectionRequests > 0 || isset($pendingRHRequests) && $pendingRHRequests > 0 && auth()->user()->can('ver modulo rrhh'))
                    <span class="badge bg-danger ms-2">{{ (isset($pendingManagerRequests) ? $pendingManagerRequests : 0) + (isset($pendingDirectionRequests) ? $pendingDirectionRequests : 0) + (isset($pendingRHRequests) && auth()->user()->can('ver modulo rrhh') ? $pendingRHRequests : 0) }}</span>
                @endif
            </a>
            <ul class="nav-main-submenu">

                @can('ver modulo rrhh')
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('vacaciones.reporte') }}">
                        <span class="nav-main-link-name">Reporte de Vacaciones</span>
                    </a>
                </li>
                @endcan


                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('vacaciones.index') }}">
                        <span class="nav-main-link-name">Mis Solicitudes</span>
                    </a>
                </li>
                {{-- Solicitudes de jefe directo --}}
                @if($hasSubordinates || $pendingManagerRequests > 0) 
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('vacaciones.aprobar') }}">
                            <span class="nav-main-link-name">Solicitudes Jefe Directo</span>
                            @if(isset($pendingManagerRequests) && $pendingManagerRequests > 0)
                                <span class="badge bg-warning text-dark ms-auto">{{ $pendingManagerRequests }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                    
                {{-- Solicitudes de dirección --}}
                @if( $userHasDirectionRole || $pendingDirectionRequests > 0)
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('vacaciones.direccion') }}">
                            <span class="nav-main-link-name">Solicitudes Dirección</span>
                            @if(isset($pendingDirectionRequests) && $pendingDirectionRequests > 0)
                                <span class="badge bg-info text-white ms-auto">{{ $pendingDirectionRequests }}</span>
                            @endif
                        </a>
                    </li>
                @endif
         
                @can('ver modulo rrhh')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('vacaciones.rh') }}">
                            <span class="nav-main-link-name">Solicitudes RH</span>
                            @if(isset($pendingRHRequests) && $pendingRHRequests > 0)
                                <span class="badge bg-danger ms-auto">{{ $pendingRHRequests }}</span>
                            @endif
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        {{-- SECCIONES OCULTAS - Módulos secundarios comentados --}}
        {{-- 
        <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('perfil.informacion_personal') }}">
                <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                <span class="nav-main-link-name"> Datos personales</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('perfil.cv.show') }}">
                <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                <span class="nav-main-link-name">CV</span>
            </a>
        </li>
        <li class="nav-main-item">

            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                aria-expanded="false" href="#">
                <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                <span class="nav-main-link-name">Requisicion de personal</span>
            </a>
            <ul class="nav-main-submenu">
                @can('solicitar requisicion personal')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('perfil.requisiciones.personal.index') }}">
                            <span class="nav-main-link-name">Solicitar</span>
                        </a>
                    </li>
                @endcan
                @can('requisicion personal revisar')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('perfil.requisiciones.personal.revisar.index') }}">
                            <span class="nav-main-link-name">Revisar</span>
                        </a>
                    </li>
                @endcan
                @can('requisicion personal autorizar')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('perfil.requisiciones.personal.autorizar.index') }}">
                            <span class="nav-main-link-name">Autorizar</span>
                        </a>
                    </li>
                @endcan
                @can('ver modulo rrhh')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('rrhh.requisiciones.personal.index') }}">
                            <span class="nav-main-link-name">Historial</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                aria-expanded="false" href="#">
                <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                <span class="nav-main-link-name">Requisicion de curso</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('requisiciones.curso.index') }}">
                        <span class="nav-main-link-name">Mis solicitudes</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('jefe.requisiciones.curso.index') }}">
                        <span class="nav-main-link-name">Revisar por jefe directo</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('gerente.requisiciones.curso.indexGerente') }}">
                        <span class="nav-main-link-name">Revisar por gerente</span>
                    </a>
                </li>
                @can('requisicion curso autorizar')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('dg.requisiciones.curso.index') }}">
                            <span class="nav-main-link-name">Revisar por DG</span>
                        </a>
                    </li>
                @endcan
                @can('ver modulo rrhh')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('rrhh.requisiciones.curso.historial') }}">
                            <span class="nav-main-link-name">Historial</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        

        @can('sidebar colaborador')
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('empleados.index') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Colaboradores</span>
                </a>
            </li>
        @endcan
        @can('ver modulo rrhh')
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('areas') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Área</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('departamentos') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Departamentos</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('puestos.index') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Puestos</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('organigrama.index') }}">
                    <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                    <span class="nav-main-link-name">Organigrama</span>
                </a>
            </li>
        @endcan
        --}}
    </ul>


</div>
