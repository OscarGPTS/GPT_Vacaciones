@extends('layouts.codebase.master')

@section('content')
<div class="card">

    {{-- ================================================================
         Tabs navigation
    ================================================================ --}}
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <ul class="nav nav-tabs card-header-tabs border-0 mb-0" id="orgTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active"
                            id="tab-general-btn"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-general"
                            type="button" role="tab">
                        <i class="fa fa-sitemap me-1"></i> Organigrama General
                    </button>
                </li>
                @foreach($customOrgcharts as $co)
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="tab-co-{{ $co->id }}-btn"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-co-{{ $co->id }}"
                            type="button" role="tab">
                        <i class="fa fa-users me-1"></i> {{ $co->title }}
                    </button>
                </li>
                @endforeach
            </ul>

            @can('ver modulo rrhh')
                @livewire('organigrama-personalizado')
            @endcan
        </div>
    </div>

    <div class="tab-content">

    {{-- ================================================================
         TAB GENERAL
    ================================================================ --}}
    <div class="tab-pane fade show active p-3" id="tab-general" role="tabpanel">
        <!-- Controles de filtro y exportación -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="empresaFilter" class="form-label">Filtrar por empresa</label>
                <select id="empresaFilter" class="form-select">
                    <option value="">Todas las empresas</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->short_name ?: $empresa->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="departmentFilter" class="form-label">Filtrar por departamentos</label>
                <select id="departmentFilter" class="form-select" multiple>
                    @foreach($departamentos as $depto)
                        <option value="{{ $depto->id }}">{{ $depto->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Selecciona uno o varios departamentos (Ctrl+Click). Deja vacío para ver todos.</small>
            </div>
            <div class="col-md-5 d-flex align-items-end justify-content-end gap-2">
                <small class="text-muted me-2" id="employeeCount"></small>
                <button type="button" class="btn btn-primary" id="exportPdfBtn">
                    <i class="fa fa-file-pdf"></i> Exportar a PDF
                </button>
                <button type="button" class="btn btn-success" id="exportPngBtn">
                    <i class="fa fa-file-image"></i> Exportar a PNG
                </button>
            </div>
        </div>

        <!-- Contenedor del organigrama -->
        <div id="tree" style="width: 100%; height: 800px;"></div>

    </div>{{-- /tab-general --}}

    {{-- ================================================================
         TABS PERSONALIZADOS
    ================================================================ --}}
    @foreach($customOrgcharts as $co)
    <div class="tab-pane fade p-3"
         id="tab-co-{{ $co->id }}"
         role="tabpanel"
         data-chart-id="{{ $co->id }}">

        {{-- Header con info + acciones (solo RH) --}}
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <h5 class="mb-0 fw-bold">{{ $co->title }}</h5>
                @if($co->description)
                    <small class="text-muted">{{ $co->description }}</small>
                @endif
                <div class="mt-1">
                    <small class="text-muted">
                        <i class="fa fa-users me-1"></i>
                        {{ count($co->nodes ?? []) }} integrante{{ count($co->nodes ?? []) !== 1 ? 's' : '' }}
                    </small>
                </div>
            </div>
            @can('ver modulo rrhh')
            <div class="d-flex gap-2 flex-shrink-0">
                <button class="btn btn-sm btn-outline-secondary"
                        onclick="Livewire.dispatch('editOrgchart', { id: {{ $co->id }} })">
                    <i class="fa fa-edit me-1"></i> Editar
                </button>
                <button class="btn btn-sm btn-outline-danger"
                        onclick="if(confirm('¿Eliminar el organigrama \"{{ addslashes($co->title) }}\"? Esta acción no se puede deshacer.')) Livewire.dispatch('deleteOrgchart', { id: {{ $co->id }} })">
                    <i class="fa fa-trash me-1"></i> Eliminar
                </button>
            </div>
            @endcan
        </div>

        {{-- Contenedor del organigrama personalizado --}}
        <div id="tree-co-{{ $co->id }}" style="width:100%; height:750px;">
            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                <i class="fa fa-spinner fa-spin me-2"></i> Cargando organigrama…
            </div>
        </div>

    </div>{{-- /tab-co-{{ $co->id }} --}}
    @endforeach

    </div>{{-- /tab-content --}}
</div>
@endsection

@push('scripts')
    <!-- Librerías necesarias -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://balkan.app/js/OrgChart.js"></script>
    
    <style>
        /* La barra de búsqueda se oculta temporalmente solo durante la exportación */
    </style>
    
    <!-- Librerías para exportación -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        let chart; // Variable global para acceder al chart desde las funciones de exportación

        console.log('Cargando organigrama...');
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar Select2 para selección múltiple
            $('#departmentFilter').select2({
                placeholder: 'Selecciona uno o varios departamentos',
                allowClear: true,
                width: '100%'
            });

            // Cargar organigrama inicial
            loadOrgChart();

            // Evento al cambiar el filtro de empresa
            $('#empresaFilter').on('change', function() {
                loadOrgChart();
            });

            // Evento al cambiar el filtro de departamentos
            $('#departmentFilter').on('change', function() {
                loadOrgChart();
            });

            // Eventos de exportación
            document.getElementById('exportPdfBtn').addEventListener('click', exportToPDF);
            document.getElementById('exportPngBtn').addEventListener('click', exportToPNG);
        });

        function loadOrgChart(convertImages = false) {
            const selectedDepartments = $('#departmentFilter').val(); // Array de IDs
            const selectedEmpresa = $('#empresaFilter').val(); // ID de empresa
            
            let url = "{{ route('organigrama.getEmployees') }}";
            const params = [];

            if (selectedDepartments && selectedDepartments.length > 0) {
                params.push('departments=' + selectedDepartments.join(','));
            }
            if (selectedEmpresa) {
                params.push('empresa=' + selectedEmpresa);
            }
            if (convertImages) {
                params.push('convert_images=true');
            }
            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            return fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        document.getElementById('tree').innerHTML = "<p>No hay datos para mostrar</p>";
                        return null;
                    }

                    console.log('Datos recibidos para organigrama:', data.length, 'empleados');
                    
                    // Limpiar contenedor
                    document.getElementById('tree').innerHTML = '';
                    
                    // Crear organigrama
                    chart = new OrgChart(document.getElementById("tree"), {
                        template: "ana",
                        enableSearch: true,
                        nodeBinding: {
                            field_0: "name",
                            field_1: "title",
                            img_0: "img"
                        },
                        nodes: data
                    });

                    // Opcional: al hacer clic mostrar detalles
                    chart.on('click', function(sender, args){
                        console.log(args.node);
                    });

                    // Actualizar contador de empleados
                    updateEmployeeCount(data.length);

                    return data;
                })
                .catch(error => {
                    console.error("Error al cargar organigrama:", error);
                    document.getElementById('tree').innerHTML = "<p>Error al cargar el organigrama.</p>";
                    return null;
                });
        }

        // Función para exportar a PDF
        async function exportToPDF() {
            if (!chart) {
                alert('El organigrama aún no está cargado');
                return;
            }

            const button = document.getElementById('exportPdfBtn');
            const employeeCount = document.querySelectorAll('#tree img').length;
            const selectedDepartments = $('#departmentFilter').val();
            
            // Si hay muchos empleados y múltiples departamentos, ofrecer particionar
            if (employeeCount > 50 && selectedDepartments && selectedDepartments.length > 1) {
                const choice = confirm(
                    `El organigrama tiene ${employeeCount} empleados en ${selectedDepartments.length} departamentos.\n\n` +
                    `¿Deseas generar:\n` +
                    `• OK = UN solo PDF (puede tardar varios minutos)\n` +
                    `• Cancelar = UN PDF por cada departamento (más rápido)`
                );
                
                if (!choice) {
                    // Usuario eligió particionar por departamento
                    await exportToPDFByDepartments();
                    return;
                }
            } else if (employeeCount > 50) {
                const confirm = window.confirm(
                    `El organigrama tiene ${employeeCount} empleados.\n\n` +
                    `La exportación puede tardar varios minutos. ¿Deseas continuar?`
                );
                
                if (!confirm) {
                    return;
                }
            }
            
            // Exportar PDF único
            await exportSinglePDF(getDepartmentName(), button);
        }

        // Exportar un solo PDF con todas las fotos
        async function exportSinglePDF(filename, button) {
            button.disabled = true;
            
            try {
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Preparando imágenes...';
                await loadOrgChart(true);
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generando PDF...';
                
                // Ocultar barra de búsqueda solo durante la captura
                hideSearchBar();
                // Capturar con configuración optimizada
                const canvas = await html2canvas(document.getElementById('tree'), {
                    scale: 1.5,
                    allowTaint: false,
                    useCORS: false,
                    logging: false,
                    backgroundColor: '#ffffff',
                    removeContainer: false
                });
                showSearchBar();

                const imgData = canvas.toDataURL('image/png', 0.95);
                const { jsPDF } = window.jspdf;
                
                // Crear PDF en orientación horizontal
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4',
                    compress: true
                });
                
                // Calcular dimensiones
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = pdfWidth - 20;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                
                // Cargar logo para agregarlo en cada página
                const logoImg = await loadImageAsBase64('{{ asset("assets/images/logo/logo_GPT.png") }}');
                const logoWidth = 30; // mm
                const logoHeight = 15; // mm (ajustar según proporción real del logo)
                
                // Si la imagen es muy alta, crear múltiples páginas
                if (imgHeight > pdfHeight - 20) {
                    let remainingHeight = imgHeight;
                    let sourceY = 0;
                    let pageNum = 0;
                    
                    while (remainingHeight > 0) {
                        if (pageNum > 0) {
                            pdf.addPage();
                        }
                        
                        const pageHeight = Math.min(pdfHeight - 20, remainingHeight);
                        const sourceHeight = (pageHeight * canvas.height) / imgHeight;
                        const canvas2 = document.createElement('canvas');
                        canvas2.width = canvas.width;
                        canvas2.height = sourceHeight;
                        
                        const ctx2 = canvas2.getContext('2d');
                        ctx2.drawImage(canvas, 0, sourceY, canvas.width, sourceHeight, 0, 0, canvas.width, sourceHeight);
                        
                        const pageImgData = canvas2.toDataURL('image/png', 0.95);
                        pdf.addImage(pageImgData, 'PNG', 10, 10, imgWidth, pageHeight);
                        
                        // Agregar logo en esquina superior derecha
                        if (logoImg) {
                            pdf.addImage(logoImg, 'PNG', pdfWidth - logoWidth - 10, 10, logoWidth, logoHeight);
                        }
                        
                        remainingHeight -= pageHeight;
                        sourceY += sourceHeight;
                        pageNum++;
                    }
                } else {
                    pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
                    
                    // Agregar logo en esquina superior derecha
                    if (logoImg) {
                        pdf.addImage(logoImg, 'PNG', pdfWidth - logoWidth - 10, 10, logoWidth, logoHeight);
                    }
                }
                
                // Descargar
                pdf.save(filename + '.pdf');
                console.log('PDF generado exitosamente');
                
                // Restaurar vista original
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Restaurando...';
                await loadOrgChart(false);
                
            } catch (error) {
                console.error('Error al exportar PDF:', error);
                alert('Error al generar PDF: ' + error.message);
            } finally {
                button.disabled = false;
                button.innerHTML = '<i class="fa fa-file-pdf"></i> Exportar a PDF';
            }
        }

        // Exportar múltiples PDFs, uno por departamento
        async function exportToPDFByDepartments() {
            const button = document.getElementById('exportPdfBtn');
            const selectedDepartments = $('#departmentFilter').select2('data');
            
            if (!selectedDepartments || selectedDepartments.length === 0) {
                alert('Debes seleccionar al menos un departamento');
                return;
            }
            
            button.disabled = true;
            const originalSelection = $('#departmentFilter').val();
            
            try {
                for (let i = 0; i < selectedDepartments.length; i++) {
                    const dept = selectedDepartments[i];
                    
                    button.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Procesando ${i + 1}/${selectedDepartments.length}: ${dept.text}...`;
                    
                    // Cambiar filtro a solo este departamento
                    $('#departmentFilter').val([dept.id]).trigger('change');
                    await new Promise(resolve => setTimeout(resolve, 500));
                    
                    // Cargar con imágenes
                    button.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Cargando ${dept.text}...`;
                    await loadOrgChart(true);
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    
                    // Generar PDF
                    button.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Generando PDF ${i + 1}/${selectedDepartments.length}...`;
                    
                    // Ocultar barra de búsqueda solo durante la captura
                    hideSearchBar();
                    const canvas = await html2canvas(document.getElementById('tree'), {
                        scale: 1.5,
                        allowTaint: false,
                        useCORS: false,
                        logging: false,
                        backgroundColor: '#ffffff'
                    });

                    const imgData = canvas.toDataURL('image/png', 0.95);
                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF({
                        orientation: 'landscape',
                        unit: 'mm',
                        format: 'a4',
                        compress: true
                    });
                    
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = pdfWidth - 20;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;
                    
                    // Cargar logo
                    const logoImg = await loadImageAsBase64('{{ asset("assets/images/logo/logo_GPT.png") }}');
                    const logoWidth = 30;
                    const logoHeight = 15;
                    
                    if (imgHeight > pdfHeight - 20) {
                        let remainingHeight = imgHeight;
                        let sourceY = 0;
                        let pageNum = 0;
                        
                        while (remainingHeight > 0) {
                            if (pageNum > 0) {
                                pdf.addPage();
                            }
                            
                            const pageHeight = Math.min(pdfHeight - 20, remainingHeight);
                            const sourceHeight = (pageHeight * canvas.height) / imgHeight;
                            const canvas2 = document.createElement('canvas');
                            canvas2.width = canvas.width;
                            canvas2.height = sourceHeight;
                            
                            const ctx2 = canvas2.getContext('2d');
                            ctx2.drawImage(canvas, 0, sourceY, canvas.width, sourceHeight, 0, 0, canvas.width, sourceHeight);
                            
                            const pageImgData = canvas2.toDataURL('image/png', 0.95);
                            pdf.addImage(pageImgData, 'PNG', 10, 10, imgWidth, pageHeight);
                            
                            // Agregar logo en cada página
                            if (logoImg) {
                                pdf.addImage(logoImg, 'PNG', pdfWidth - logoWidth - 10, 10, logoWidth, logoHeight);
                            }
                            
                            remainingHeight -= pageHeight;
                            sourceY += sourceHeight;
                            pageNum++;
                        }
                    } else {
                        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
                        
                        // Agregar logo
                        if (logoImg) {
                            pdf.addImage(logoImg, 'PNG', pdfWidth - logoWidth - 10, 10, logoWidth, logoHeight);
                        }
                    }
                    
                    // Nombre de archivo limpio
                    const filename = 'organigrama-' + dept.text
                        .toLowerCase()
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "")
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    
                    pdf.save(filename + '.pdf');
                    console.log(`PDF ${i + 1}/${selectedDepartments.length} generado: ${filename}.pdf`);
                    
                    await new Promise(resolve => setTimeout(resolve, 500));
                }
                
                alert(`Se generaron ${selectedDepartments.length} PDFs exitosamente`);
                
                // Restaurar selección original
                $('#departmentFilter').val(originalSelection).trigger('change');
                await loadOrgChart(false);
                
            } catch (error) {
                console.error('Error al exportar PDFs:', error);
                alert('Error al generar PDFs: ' + error.message);
                
                // Restaurar selección original
                $('#departmentFilter').val(originalSelection).trigger('change');
                await loadOrgChart(false);
            } finally {
                button.disabled = false;
                button.innerHTML = '<i class="fa fa-file-pdf"></i> Exportar a PDF';
            }
        }

        // Función para exportar a PNG
        async function exportToPNG() {
            if (!chart) {
                alert('El organigrama aún no está cargado');
                return;
            }

            const filename = getDepartmentName();
            const button = document.getElementById('exportPngBtn');
            const employeeCount = document.querySelectorAll('#tree img').length;
            
            // Advertencia si hay muchos empleados
            if (employeeCount > 50) {
                const confirm = window.confirm(
                    `El organigrama tiene ${employeeCount} empleados.\n\n` +
                    `La exportación puede tardar varios minutos. ¿Deseas continuar?`
                );
                
                if (!confirm) {
                    return;
                }
            }
            
            button.disabled = true;
            
            try {
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Preparando imágenes...';
                await loadOrgChart(true);
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generando PNG...';
                
                // Ocultar barra de búsqueda solo durante la captura
                hideSearchBar();
                // Capturar organigrama
                const orgCanvas = await html2canvas(document.getElementById('tree'), {
                    scale: 1.5,
                    allowTaint: false,
                    useCORS: false,
                    logging: false,
                    backgroundColor: '#ffffff'
                });
                showSearchBar();

                // Crear canvas final con logo
                const finalCanvas = document.createElement('canvas');
                finalCanvas.width = orgCanvas.width;
                finalCanvas.height = orgCanvas.height;
                const ctx = finalCanvas.getContext('2d');
                
                // Dibujar organigrama primero
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);
                ctx.drawImage(orgCanvas, 0, 0);
                
                // Cargar y agregar logo
                try {
                    const logoUrl = '{{ asset("assets/images/logo/logo_GPT.png") }}';
                    console.log('Cargando logo desde:', logoUrl);
                    
                    const logoImg = await loadImage(logoUrl);
                    if (logoImg) {
                        const logoWidth = 200; // px
                        const logoHeight = 100; // px
                        const margin = 20;
                        
                        // Dibujar logo en esquina superior derecha
                        ctx.drawImage(logoImg, finalCanvas.width - logoWidth - margin, margin, logoWidth, logoHeight);
                        console.log('Logo agregado al PNG exitosamente en posición:', {
                            x: finalCanvas.width - logoWidth - margin,
                            y: margin,
                            width: logoWidth,
                            height: logoHeight
                        });
                    } else {
                        console.warn('logoImg es null o undefined');
                    }
                } catch (logoError) {
                    console.warn('No se pudo cargar el logo:', logoError);
                }

                // Descargar
                finalCanvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = filename + '.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                    
                    console.log('PNG descargado exitosamente');
                }, 'image/png', 0.95);
                
                // Restaurar vista original
                await new Promise(resolve => setTimeout(resolve, 500));
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Restaurando...';
                await loadOrgChart(false);
                
            } catch (error) {
                console.error('Error al exportar PNG:', error);
                alert('Error al generar PNG: ' + error.message);
            } finally {
                button.disabled = false;
                button.innerHTML = '<i class="fa fa-file-image"></i> Exportar a PNG';
            }
        }

        // Función helper para cargar imagen como base64 (para PDF)
        async function loadImageAsBase64(url) {
            try {
                const response = await fetch(url);
                const blob = await response.blob();
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(blob);
                });
            } catch (error) {
                console.error('Error cargando logo:', error);
                return null;
            }
        }

        // Función helper para cargar imagen como elemento Image (para PNG/Canvas)
        async function loadImage(url) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                // No usar crossOrigin para imágenes locales
                img.onload = () => {
                    console.log('Logo cargado exitosamente:', {
                        url: url,
                        width: img.width,
                        height: img.height,
                        naturalWidth: img.naturalWidth,
                        naturalHeight: img.naturalHeight
                    });
                    resolve(img);
                };
                img.onerror = (error) => {
                    console.error('Error cargando logo:', {
                        url: url,
                        error: error
                    });
                    reject(error);
                };
                img.src = url;
            });
        }

        // Actualizar contador de empleados
        function updateEmployeeCount(count) {
            const countElement = document.getElementById('employeeCount');
            if (countElement) {
                countElement.textContent = `(${count} empleado${count !== 1 ? 's' : ''})`;
                
                // Advertencia visual si son muchos empleados
                if (count > 50) {
                    countElement.classList.add('text-warning');
                    countElement.title = 'Organigrama grande: exportar con fotos puede tardar';
                } else {
                    countElement.classList.remove('text-warning');
                    countElement.title = '';
                }
            }
        }

        // Helpers para ocultar/mostrar la barra de búsqueda durante exportación
        function hideSearchBar() {
            document.querySelectorAll('#tree .boc-search').forEach(el => el.style.display = 'none');
        }

        function showSearchBar() {
            document.querySelectorAll('#tree .boc-search').forEach(el => el.style.display = '');
        }

        // Función auxiliar para obtener el nombre de archivo según selección
        function getDepartmentName() {
            const selectedDepartments = $('#departmentFilter').select2('data');
            
            if (!selectedDepartments || selectedDepartments.length === 0) {
                return 'organigrama-completo';
            } else if (selectedDepartments.length === 1) {
                const name = selectedDepartments[0].text
                    .toLowerCase()
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "") // Quitar acentos
                    .replace(/[^a-z0-9]+/g, '-') // Reemplazar espacios y caracteres especiales
                    .replace(/^-+|-+$/g, ''); // Quitar guiones al inicio/final
                return 'organigrama-' + name;
            } else {
                return 'organigrama-' + selectedDepartments.length + '-departamentos';
            }
        }

        // ================================================================
        // Organigramas personalizados: cargar al activar tab
        // ================================================================
        const orgTabsEl = document.getElementById('orgTabs');
        if (orgTabsEl) {
            orgTabsEl.addEventListener('shown.bs.tab', function (event) {
                const target = event.target.getAttribute('data-bs-target');
                const pane   = document.querySelector(target);
                if (!pane) return;

                const chartId = pane.getAttribute('data-chart-id');
                if (!chartId) return; // Es el tab General

                const containerId = 'tree-co-' + chartId;
                const container   = document.getElementById(containerId);
                if (!container || container.dataset.chartLoaded) return; // Ya inicializado

                // Fetch data from controller endpoint
                fetch('{{ url("organigrama/custom") }}/' + chartId + '/data')
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (!data || data.length === 0) {
                            container.innerHTML = '<p class="text-center text-muted p-5">Este organigrama no tiene integrantes aún.</p>';
                            return;
                        }
                        container.innerHTML = '';
                        new OrgChart(container, {
                            template: 'ana',
                            enableSearch: true,
                            nodeBinding: {
                                field_0: 'name',
                                field_1: 'title',
                                img_0:   'img'
                            },
                            nodes: data
                        });
                        container.dataset.chartLoaded = 'true';
                    })
                    .catch(function (err) {
                        console.error('Error al cargar organigrama personalizado:', err);
                        container.innerHTML = '<p class="text-center text-danger p-5">Error al cargar el organigrama.</p>';
                    });
            });
        }
    </script>
@endpush