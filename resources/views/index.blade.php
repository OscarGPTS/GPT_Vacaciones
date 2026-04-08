@extends('layouts.codebase.master')

@section('content')
@can('ver modulo rrhh')
<div class="row">
    <div class="col-md-6">
        <x-card title="Cumpleañeros del mes">
            <ul class="list-group">
                @foreach ($userBirthday as $birthday)
                <li class="list-group-item">
                    <div class="flex-row d-flex justify-content-start align-items-center">
                        <div>
                            <img class="w-10 h-10 border rounded-full border-slate-700"
                                src="{{ $birthday->user->profile_image }}" alt="" />
                        </div>
                        <div class="d-flex ms-2 flex-column">
                            <span class="fw-bold">{{ $birthday->user->nombre() }}</span>
                            <small class="fw-bold text-muted">{{
                                $birthday->user->personalData->birthday->format('Y-m-d') }}</small>
                            <small class="text-muted">
                                @empty($birthday->user->email)
                                Sin correo
                                @else
                                {{ $birthday->user->email }}
                                @endempty
                            </small>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </x-card>
    </div>
    <div class="col-md-6">
        <x-card title="Aniversarios del mes">
            <ul class="list-group">
                @foreach ($usersAniversario as $user)
                <li class="list-group-item">
                    <div class="flex-row d-flex justify-content-start align-items-center">
                        <div>
                            <img class="w-10 h-10 border rounded-full border-slate-700" src="{{ $user->profile_image }}"
                                alt="" />
                        </div>
                        <div class="ms-2 d-flex flex-column">
                            <span class="fw-bold">{{ $user->nombre() }}</span>
                            <small class="fw-bold text-muted">{{ $user->admission->format('Y-m-d') }}</small>

                            <small class="text-muted">
                                @empty($user->email)
                                Sin correo
                                @else
                                {{ $user->email }}
                                @endempty
                            </small>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </x-card>
    </div>
</div>
@endcan
<div class="row">
    <div class="col-md-12">
        <div id="chart-container"></div>
    </div>
</div>
@push('scripts')
{{-- <script src="{{ asset('js/echarts.js') }}"></script> --}}
<script src="https://fastly.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://fastly.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
<script type="text/javascript">
    let datos = '';
        var dom = document.getElementById('chart-container');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};
        var ROOT_PATH = 'https://echarts.apache.org/examples';
        var option;
            fetch('{{asset('miserables.json')}}')
                .then(response => response.json())
                .then(data => {
                    myChart.showLoading();
                    myChart.hideLoading();
                    data.nodes.forEach(function(node) {
                        node.symbolSize = 5;
                    });
                    option = {
                        title: {
                            text: 'Les Miserables',
                            subtext: 'Default layout',
                            top: 'bottom',
                            left: 'right'
                        },
                        tooltip: {},
                        legend: [{
                            // selectedMode: 'single',
                            data: data.categories.map(function(a) {
                                return a.name;
                            })
                        }],
                        series: [{
                            name: 'Les Miserables',
                            type: 'graph',
                            layout: 'force',
                            data: data.nodes,
                            links: data.links,
                            categories: data.categories,
                            roam: true,
                            label: {
                                position: 'right'
                            },
                            force: {
                                repulsion: 100
                            }
                        }]
                    };
                    myChart.setOption(option);
                    // $.get(ROOT_PATH + '/data/asset/data/les-miserables.json', function(graph) {

                });

            // });

            if (option && typeof option === 'object') {
                myChart.setOption(option);
            }

            window.addEventListener('resize', myChart.resize);
</script>
@endpush
@endsection
