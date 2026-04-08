<x-card title="Respuestas">
   @if($history)
    <div class="list-group">
        @foreach ($history as $item)
            @if (!$loop->first)
                <div class="my-1 list-group-item list-group-item-action">
                    <div class="d-flex flex-column w-100 justify-content-between">
                        <p class="mb-1 fw-bold">{{ $item->responsible->nombre() }}</p>
                        <div class="justify-content-between align-items-center d-flex">
                            <span class="text-muted">{{ $item->from }}</span>
                            <small class="text-muted">{{ $item->created_at }}</small>
                        </div>
                    </div>
                    @if (isset($item->custom_properties['motivo']))
                        <hr>
                        <small>{{ $item->custom_properties['motivo'] }}</small>
                    @endif
                </div>
            @endif
            @if ($loop->last && $loop->iteration > 2)
                <div class="my-1 list-group-item list-group-item-action">
                    <div class="d-flex flex-column w-100 justify-content-between">
                        <p class="mb-1 fw-bold">{{ $item->responsible->nombre() }}</p>
                        <div class="justify-content-between align-items-center d-flex">
                            <span class="text-muted">{{ $item->to }}</span>
                            <small class="text-muted">{{ $item->created_at }}</small>
                        </div>
                    </div>
                    @if (isset($item->custom_properties['motivo']))
                        <hr>
                        <small>{{ $item->custom_properties['motivo'] }}</small>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
    @endif
</x-card>
