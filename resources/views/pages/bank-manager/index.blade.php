@extends('layouts\template')

@section('content')
    <div class="flex">
        <main class="flex-1 px-8 py-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-100">Página de Gestão de Banco</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="col-span-1 bg-gray-700 rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Adicionar Tipo de Operação</h3>

                    <form action="{{ route('bank-manager.operation-categories.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="operation_type" class="block text-sm text-gray-300 mb-1">Tipo de Operação</label>
                            <select id="operation_type" name="operation_type" required
                                class="w-full rounded bg-gray-800 border border-gray-600 p-2 text-white">
                                <option value="income">Entrada (Income)</option>
                                <option value="expense">Saída (Expense)</option>
                            </select>
                        </div>

                        <div>
                            <label for="name" class="block text-sm text-gray-300 mb-1">Nome do Tipo</label>
                            <input type="text" id="name" name="name" required
                                class="w-full rounded bg-gray-800 border border-gray-600 p-2 text-white">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 p-2 rounded text-white font-bold">
                            Adicionar
                        </button>
                    </form>
                </div>
            </div>
        </main>


        @php
            $saldo = $balance->balance;
            $saldoCor = $saldo >= 0 ? 'text-green-400' : 'text-red-400';
        @endphp




        <div class="mb-6">
            <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-lg text-center">
                <h3 class="text-lg font-semibold text-gray-400 mb-2">Saldo atual</h3>
                <p class="text-4xl font-bold {{ $saldoCor }}">
                    € {{ number_format($saldo, 2, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-300 mb-4">Últimas Transações</h3>
        
            <ul class="divide-y divide-gray-700 bg-gray-800 rounded-lg overflow-hidden shadow-md">
                @forelse ($transactions as $transaction)
                    @php
                        $type = $transaction->operationCategory?->operationType?->operation_type ?? 'unknown';
                        $color = $type === 'income' ? 'text-green-400' : ($type === 'expense' ? 'text-red-400' : 'text-gray-400');
                    @endphp
                    <li class="flex justify-between items-center px-5 py-4">
                        <div>
                            <p class="font-semibold text-white">
                                {{ $transaction->operationCategory?->name ?? 'Categoria desconhecida' }}
                            </p>
                            <p class="text-sm text-gray-400">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <p class="text-xl font-semibold {{ $color }}">
                            € {{ number_format($transaction->amount, 2, ',', '.') }}
                        </p>
                    </li>
                @empty
                    <li class="px-5 py-4 text-gray-400 text-sm text-center">Nenhuma transação registrada.</li>
                @endforelse
            </ul>
            
        </div>


        <div x-data="bankForm()" class="bg-gray-800 p-8 rounded-lg shadow-md text-white max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-6">Adicionar Operação</h2>

            <form action="{{ route('bank-manager.transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Tipo de Operação -->
                <div>
                    <label for="operation_type" class="block mb-2 text-sm font-medium">Tipo de Operação</label>
                    <select id="operation_type" name="operation_type" x-model="selectedType" @change="updateCategories"
                        class="w-full rounded-md bg-gray-700 border border-gray-600 p-3">
                        <option value="">Selecione um tipo</option>
                        <template x-for="type in types" :key="type.id">
                            <option :value="type.id" x-text="type.operation_type"></option>
                        </template>
                    </select>
                </div>

                <!-- Categoria -->
                <div>
                    <label for="operation_category" class="block mb-2 text-sm font-medium">Categoria</label>
                    <select id="operation_category" name="operation_category_id" x-model="selectedCategory"
                        class="w-full rounded-md bg-gray-700 border border-gray-600 p-3">
                        <option value="">Selecione uma categoria</option>
                        <template x-for="category in filteredCategories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                </div>

                <!-- Valor -->
                <div>
                    <label for="amount" class="block mb-2 text-sm font-medium">Valor</label>
                    <input type="number" id="amount" name="amount" step="0.01" required
                        class="w-full rounded-md bg-gray-700 border border-gray-600 p-3">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 p-3 rounded-md font-semibold">
                    Salvar Operação
                </button>
            </form>

        </div>

    </div>


    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Categorias de Operações</h1>

        <div class="mb-4">
            <label for="typeFilter" class="text-white block mb-1">Filtrar por Tipo</label>
            <select id="typeFilter" class="w-full md:w-1/3 rounded p-2">
                <option value="">Todos</option>
                @foreach ($types as $type)
                    <option value="{{ $type->operation_type }}">{{ ucfirst($type->operation_type) }}</option>
                @endforeach
            </select>
        </div>

        <table id="categoryTable" class="w-full text-sm text-left text-gray-400 bg-gray-800 rounded-lg overflow-hidden">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Categoria</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    @foreach ($type->categories as $category)
                        <tr data-type="{{ $type->operation_type }}">
                            <td class="px-4 py-2">{{ ucfirst($type->operation_type) }}</td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4 flex gap-4">
        <select id="typeFilter" class="p-2 rounded text-black">
            <option value="">Todos os Tipos</option>
            <option value="income">Entrada</option>
            <option value="expense">Saída</option>
        </select>
    
        <input type="text" id="minDate" class="p-2 rounded text-black" placeholder="Data início (yyyy-mm-dd)">
        <input type="text" id="maxDate" class="p-2 rounded text-black" placeholder="Data fim (yyyy-mm-dd)">
    </div>
    
    <table id="transactionsTable" class="display w-full">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                @php
                    $type = $transaction->operationCategory?->operationType?->operation_type ?? 'unknown';
                    $color = $type === 'income' ? 'text-green-400' : ($type === 'expense' ? 'text-red-400' : 'text-gray-400');
                @endphp
                <tr>
                    <td>{{ $transaction->operationCategory->name ?? 'Sem categoria' }}</td>
                    <td>{{ $type }}</td>
                    <td class="{{ $color }}">€ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection


@section('scripts')
    <script>
        function bankForm() {
            return {
                types: @json($operationTypes), // Recebe do Controller
                categories: @json($operationCategories), // Recebe do Controller
                selectedType: '',
                selectedCategory: '',
                get filteredCategories() {
                    return this.categories.filter(c => c.operation_type_id == this.selectedType);
                },
                updateCategories() {
                    this.selectedCategory = '';
                }
            }
        }
    </script>

<script>
    let table = $('#transactionsTable').DataTable();

    // Tipo de operação
    $('#typeFilter').on('change', function () {
        table.column(1).search(this.value).draw();
    });

    // Filtro de datas
    $.fn.dataTable.ext.search.push(function (settings, data) {
        let min = $('#minDate').val();
        let max = $('#maxDate').val();
        let date = data[3]; // 4ª coluna (Data)

        if ((min === "" || date >= min) && (max === "" || date <= max)) {
            return true;
        }
        return false;
    });

    $('#minDate, #maxDate').on('change', function () {
        table.draw();
    });
</script>

@endsection
