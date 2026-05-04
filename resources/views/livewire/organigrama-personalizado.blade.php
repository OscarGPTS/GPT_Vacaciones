<div>
    @can('ver modulo rrhh')
    <button type="button" wire:click="openCreate" class="btn btn-primary btn-sm">
        <i class="fa fa-plus me-1"></i> Nuevo organigrama
    </button>
    @endcan

    {{-- ================================================================
         Builder Modal — split layout: form | live preview
    ================================================================ --}}
    @if($showModal)
    <div class="modal show d-block" tabindex="-1" role="dialog" style="background-color:rgba(0,0,0,.55); z-index:1055;">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document" style="max-width:1300px;">
            <div class="modal-content bg-white">

                {{-- Header --}}
                <div class="modal-header py-2 bg-light">
                    <h5 class="modal-title fw-bold mb-0">
                        <i class="fa fa-users me-2 text-primary"></i>
                        {{ $editingId ? 'Editar: ' . $title : 'Nuevo organigrama personalizado' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>

                {{-- Body — two columns --}}
                <div class="modal-body p-0">
                    <div class="row g-0" style="min-height:600px;">

                        {{-- ============ LEFT: form ============ --}}
                        <div class="col-lg-6 border-end p-3 overflow-auto" style="max-height:78vh;">

                            <h6 class="fw-bold text-uppercase text-muted small mb-2">
                                <i class="fa fa-info-circle me-1"></i> Información
                            </h6>
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1">Título <span class="text-danger">*</span></label>
                                    <input type="text"
                                           wire:model="title"
                                           class="form-control form-control-sm @error('title') is-invalid @enderror"
                                           placeholder="Ej. Brigada de primeros auxilios">
                                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1">Descripción <span class="text-muted">(opcional)</span></label>
                                    <input type="text"
                                           wire:model="description"
                                           class="form-control form-control-sm @error('description') is-invalid @enderror"
                                           placeholder="Breve descripción">
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr class="my-2">

                            <h6 class="fw-bold text-uppercase text-muted small mb-2">
                                <i class="fa fa-user-plus me-1 text-success"></i> Agregar integrante
                            </h6>

                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <label class="form-label small mb-1">Buscar empleado</label>
                                    <div class="position-relative">
                                        <input type="text"
                                               wire:model.live.debounce.300ms="searchUser"
                                               class="form-control form-control-sm"
                                               placeholder="Nombre o apellido…"
                                               autocomplete="off">
                                        @if($this->searchResults->count() > 0)
                                        <ul class="list-group position-absolute w-100 shadow"
                                            style="z-index:9999; max-height:200px; overflow-y:auto; top:100%;">
                                            @foreach($this->searchResults as $usr)
                                            <li class="list-group-item list-group-item-action py-2 px-3"
                                                style="cursor:pointer;"
                                                wire:click="selectUser({{ $usr->id }})"
                                                wire:key="sr-{{ $usr->id }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $usr->profile_image ?: asset('assets/images/default-avatar.svg') }}"
                                                         width="32" height="32"
                                                         class="rounded-circle flex-shrink-0"
                                                         style="object-fit:cover;">
                                                    <div>
                                                        <div class="fw-semibold small lh-1">
                                                            {{ trim(($usr->last_name ?? '') . ' ' . ($usr->first_name ?? '')) }}
                                                        </div>
                                                        <div class="text-muted" style="font-size:.7rem">
                                                            {{ $usr->job?->name ?? 'Sin puesto' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    @if($selectedUserId)
                                    <div class="mt-1">
                                        <span class="badge bg-success small">
                                            <i class="fa fa-check me-1"></i> Seleccionado
                                            <button type="button"
                                                    class="btn-close btn-close-white ms-1"
                                                    wire:click="$set('selectedUserId', null); $set('searchUser', '');"
                                                    style="font-size:.5rem; vertical-align:middle;"></button>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-5">
                                    <label class="form-label small mb-1">Rol / Etiqueta</label>
                                    <input type="text"
                                           wire:model="nodeLabel"
                                           class="form-control form-control-sm"
                                           placeholder="Ej. Coordinador…">
                                </div>
                                <div class="col-sm-5">
                                    <label class="form-label small mb-1">Reporta a</label>
                                    <select wire:model="nodeParentId" class="form-select form-select-sm">
                                        <option value="">— Nodo raíz —</option>
                                        @foreach($nodes as $n)
                                        <option value="{{ $n['user_id'] }}">
                                            {{ $n['user_name'] }}{{ $n['label'] ? ' (' . $n['label'] . ')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 d-flex align-items-end">
                                    <button type="button"
                                            wire:click="addNode"
                                            class="btn btn-success btn-sm w-100"
                                            @if(!$selectedUserId) disabled @endif>
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Node list --}}
                            @if(count($nodes) > 0)
                            <h6 class="fw-bold text-uppercase text-muted small mb-2">
                                <i class="fa fa-list-ul me-1 text-primary"></i>
                                Integrantes <span class="badge bg-secondary">{{ count($nodes) }}</span>
                            </h6>
                            <div class="table-responsive" style="max-height:260px; overflow-y:auto;">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top" style="font-size:.75rem;">
                                        <tr>
                                            <th>Empleado</th>
                                            <th>Rol</th>
                                            <th>Reporta a</th>
                                            <th class="text-center" style="width:44px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($nodes as $node)
                                        @php $parent = collect($nodes)->firstWhere('user_id', $node['parent_id']); @endphp
                                        <tr wire:key="node-{{ $node['user_id'] }}">
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $node['user_img'] }}"
                                                         width="30" height="30"
                                                         class="rounded-circle flex-shrink-0"
                                                         style="object-fit:cover;">
                                                    <span class="small fw-semibold">{{ $node['user_name'] }}</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-info text-white" style="font-size:.7rem;">{{ $node['label'] ?: '—' }}</span></td>
                                            <td class="text-muted" style="font-size:.72rem;">{{ $parent ? $parent['user_name'] : '— Raíz —' }}</td>
                                            <td class="text-center">
                                                <button type="button"
                                                        wire:click="removeNode({{ $node['user_id'] }})"
                                                        class="btn btn-sm btn-outline-danger py-0 px-1"
                                                        style="font-size:.75rem;"
                                                        title="Quitar">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center text-muted py-4 border rounded bg-light">
                                <i class="fa fa-users fa-2x mb-2 d-block opacity-25"></i>
                                <small>Busca y agrega empleados para comenzar.</small>
                            </div>
                            @endif

                        </div>{{-- /col left --}}

                        {{-- ============ RIGHT: live preview ============ --}}
                        <div class="col-lg-6 p-3 bg-light d-flex flex-column" style="max-height:78vh;">

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold text-uppercase text-muted small mb-0">
                                    <i class="fa fa-eye me-1 text-primary"></i> Vista previa en tiempo real
                                </h6>
                                <span class="badge bg-primary" id="preview-count">
                                    {{ count($nodes) }} nodo{{ count($nodes) !== 1 ? 's' : '' }}
                                </span>
                            </div>

                            {{-- OrgChart.js container: wire:ignore keeps it out of Livewire DOM diffing --}}
                            <div wire:ignore
                                 id="orgchart-preview-container"
                                 class="flex-grow-1 border rounded bg-white"
                                 style="min-height:480px; overflow:hidden;">
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <div class="text-center">
                                        <i class="fa fa-sitemap fa-3x mb-3 d-block opacity-20"></i>
                                        <small>Agrega integrantes para ver la vista previa</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Data bridge: Livewire updates the attribute; JS reads it --}}
                            <div id="preview-data-relay"
                                 style="display:none;"
                                 data-nodes="{{ json_encode(collect($nodes)->map(fn($n) => ['id'=>$n['user_id'],'pid'=>$n['parent_id'],'name'=>$n['user_name'],'title'=>$n['label']?:'Sin rol','img'=>$n['user_img']])->toArray()) }}">
                            </div>

                        </div>{{-- /col right --}}

                    </div>{{-- /row --}}
                </div>{{-- /modal-body --}}

                {{-- Footer --}}
                <div class="modal-footer py-2">
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            wire:click="$set('showModal', false)">
                        Cancelar
                    </button>
                    <button type="button"
                            wire:click="save"
                            class="btn btn-primary btn-sm">
                        <span wire:loading wire:target="save"><i class="fa fa-spinner fa-spin me-1"></i></span>
                        {{ $editingId ? 'Actualizar organigrama' : 'Guardar organigrama' }}
                    </button>
                </div>

            </div>{{-- /modal-content --}}
        </div>
    </div>
    @endif

    {{-- ================================================================
         JavaScript — live preview engine + page reload on save/delete
    ================================================================ --}}
    <script>
    (function() {

        let previewChart = null;

        // Render nodes array into the preview OrgChart
        function renderPreview(nodes) {
            const container = document.getElementById('orgchart-preview-container');
            const counter   = document.getElementById('preview-count');
            if (!container) return;

            if (counter) {
                const n = nodes ? nodes.length : 0;
                counter.textContent = n + (n === 1 ? ' nodo' : ' nodos');
            }

            if (!nodes || nodes.length === 0) {
                container.innerHTML =
                    '<div class="d-flex align-items-center justify-content-center h-100 text-muted">' +
                    '<div class="text-center"><i class="fa fa-sitemap fa-3x mb-3 d-block opacity-20"></i>' +
                    '<small>Agrega integrantes para ver la vista previa</small></div></div>';
                previewChart = null;
                return;
            }

            container.innerHTML = '';
            try {
                previewChart = new OrgChart(container, {
                    template: 'ana',
                    enableSearch: false,
                    nodeBinding: { field_0: 'name', field_1: 'title', img_0: 'img' },
                    nodes: nodes
                });
            } catch(e) {
                console.warn('OrgChart preview error:', e);
            }
        }

        // Fallback: read the hidden data relay div and render
        function readRelayAndRender() {
            const relay = document.getElementById('preview-data-relay');
            if (!relay) return;
            try {
                renderPreview(JSON.parse(relay.getAttribute('data-nodes') || '[]'));
            } catch(e) { /* ignore parse errors */ }
        }

        document.addEventListener('livewire:initialized', function () {

            // Page reload after save / delete
            Livewire.on('refreshOrgcharts', function () {
                window.location.reload();
            });

            // Primary channel: PHP dispatches browser event with nodes
            Livewire.on('orgchartPreviewUpdated', function (data) {
                const nodes = Array.isArray(data) ? data : (data.nodes || []);
                renderPreview(nodes);
            });

            // Secondary channel: after every Livewire re-render read the relay attribute
            Livewire.hook('commit', ({ component, succeed }) => {
                succeed(() => {
                    requestAnimationFrame(readRelayAndRender);
                });
            });
        });

    })();
    </script>
</div>
