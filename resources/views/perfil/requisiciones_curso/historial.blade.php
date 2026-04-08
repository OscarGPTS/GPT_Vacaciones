<x-card title="Historial">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                <tr>
                    <th scope="col" class="p-2">
                        Fecha
                    </th>
                    <th scope="col" class="p-2">
                        Desde
                    </th>
                    <th scope="col" class="p-2">
                        Hasta
                    </th>
                    <th scope="col" class="p-2">
                        Responsable
                    </th>
                    <th scope="col" class="p-2">
                        Observaciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisicion->status()->history()->get() as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->created_at->isoFormat('LL') }}
                        </th>
                        <td class="p-2">
                            {{ $item->from }}
                        </td>
                        <td class="p-2">
                            {{ $item->to }}
                        </td>
                        <td class="p-2">
                            {{ $item->responsible->nombre() }}
                        </td>
                        <td class="p-2 text-right">
                            @if (isset($item->custom_properties['observaciones']))
                                {{ $item->custom_properties['observaciones'] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-card>
