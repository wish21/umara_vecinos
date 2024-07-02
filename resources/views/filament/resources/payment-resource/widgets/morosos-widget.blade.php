<x-filament::widget>
    <x-filament::card>
        <div class="text-center">
            <h2 class="text-xl font-semibold text-red-500">Morosos</h2>
            <table class="divide-y">
                <thead >
                    <tr>
                        <th class="px-6 py-3 text-center  font-black tracking-wider">Casa</th>
                        <th class="px-6 py-3 text-center  font-black tracking-wider">Meses vencidos</th>
                        <th class="px-6 py-3 text-center  font-black tracking-wider">Lista de meses</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-gray-200">
                    @foreach ($debtors as $debtor)
                        <tr>
                            <td class="px-6 py-4 text-xs font-thin	whitespace-nowrap">{{ $debtor['house']->street.' '.$debtor['house']->number }}</td>
                            <td class="px-6 py-4 text-xs font-thin	whitespace-nowrap">{{ $debtor['months_due'] }}</td>
                            <td class="px-6 py-4 text-xs font-thin	whitespace-nowrap">{{ implode(', ', $debtor['months_due_list']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::card>
</x-filament::widget>
