@extends('layouts\template')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-10">

        <!-- ROW 1: Grid com 2 colunas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <!-- COLUNA 1: Agrupada com largura fixa e centralizada -->
            <div class="space-y-6 max-w-xl w-full mx-auto">

                <!-- 💰 Saldo Atual -->
                <div class="bg-gray-900 border-2 border-blue-600 p-6 rounded-lg shadow text-center">
                    <h3 class="text-lg font-semibold text-gray-400 mb-2">💰 Saldo Atual</h3>
                    <p
                        class="text-5xl font-bold 
                @if ($balance->balance > 0) text-green-400
                @elseif ($balance->balance < 0) text-red-400
                @else text-yellow-300 @endif">
                        € {{ number_format($balance->balance, 2, ',', '.') }}
                    </p>
                </div>

                <!--  Tipo de Operação -->
                <div x-data="{ open: false }" class="bg-gray-800 p-4 rounded-lg shadow">
                    <button @click="open = !open" class="w-full text-left text-white font-semibold">
                        ➕ Tipo de Operação
                    </button>
                    <div x-show="open" x-transition class="mt-4">
                        <form action="{{ route('bank-manager.operation-categories.store') }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <select name="operation_type" required
                                class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                                <option value="income">Entrada (Income)</option>
                                <option value="expense">Saída (Expense)</option>
                            </select>
                            <input type="text" name="name" placeholder="Nome da Categoria" required
                                class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 transition-colors p-3 rounded text-white font-semibold">
                                Adicionar Categoria
                            </button>
                        </form>
                    </div>
                </div>

                <!--  Adicionar Operação -> Aberto -->
                <div x-data="{ open: true }" class="bg-gray-800 p-4 rounded-lg shadow">
                    <button @click="open = !open" class="w-full text-left text-white font-semibold">
                        ➕ Adicionar Operação
                    </button>
                    <div x-show="open" x-transition class="mt-4">
                        <form action="{{ route('bank-manager.transactions.store') }}" method="POST" class="space-y-4"
                            x-data="bankForm()">
                            @csrf
                            <select id="operation_type" name="operation_type" x-model="selectedType"
                                @change="updateCategories"
                                class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                                <option value="">Tipo</option>
                                <template x-for="type in types" :key="type.id">
                                    <option :value="type.id" x-text="type.operation_type"></option>
                                </template>
                            </select>
                            <select name="operation_category_id" x-model="selectedCategory"
                                class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                                <option value="">Categoria</option>
                                <template x-for="category in filteredCategories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <input type="number" step="0.01" name="amount" placeholder="Valor"
                                class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white" required>
                            <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 transition-colors p-3 rounded text-white font-semibold">
                                Salvar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Grafico de Gestao de Gastos -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold text-white mb-4">📊 Gastos por Categoria</h3>

                <form method="GET" action="{{ route('bank-manager.index') }}" class="flex flex-wrap gap-4 mb-4">
                    <div>
                        <label for="start_date" class="text-white text-sm">Data Início</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ request('start_date') ?? now()->startOfMonth()->toDateString() }}"
                            class="bg-gray-700 border border-gray-600 text-white rounded px-3 py-2">
                    </div>

                    <div>
                        <label for="end_date" class="text-white text-sm">Data Fim</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ request('end_date') ?? now()->endOfMonth()->toDateString() }}"
                            class="bg-gray-700 border border-gray-600 text-white rounded px-3 py-2">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                            Filtrar
                        </button>
                    </div>
                </form>

                <canvas id="expenseChart" height="200"></canvas>
            </div>

        </div>


        <!-- ROW 2: Tabela -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-white mb-4 text-center">📜 Últimas Transações</h2>

            <div class="overflow-x-auto">
                <table id="transactionsTable"
                    class="min-w-full bg-gray-900 text-white rounded overflow-hidden shadow text-center">
                    <thead class="bg-gray-700 text-sm uppercase text-gray-300">
                        <tr>
                            <th class="px-6 py-3">Categoria</th>
                            <th class="px-6 py-3">Valor</th>
                            <th class="px-6 py-3">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            @php
                                $type = $transaction->operationCategory?->operationType?->operation_type ?? 'unknown';
                                $color =
                                    $type === 'income'
                                        ? 'text-green-400'
                                        : ($type === 'expense'
                                            ? 'text-red-400'
                                            : 'text-gray-400');
                            @endphp
                            <tr class="border-t border-gray-700">
                                <td class="px-6 py-4">{{ $transaction->operationCategory->name ?? 'Sem categoria' }}</td>
                                <td class="px-6 py-4 font-semibold {{ $color }}">
                                    € {{ number_format($transaction->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">{{ $transaction->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('expenseChart').getContext('2d');

            const data = {
                labels: {!! json_encode($expenseLabels) !!},
                datasets: [{
                    label: 'Gastos',
                    data: {!! json_encode($expenseValues) !!},
                    backgroundColor: [
                        '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899'
                    ],
                    hoverOffset: 8
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percent = ((value / {{ $totalIncome ?: 1 }}) * 100).toFixed(1);
                                    return `${context.label}: €${value.toFixed(2)} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        $('#typeFilter').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        // Filtro de datas
        $.fn.dataTable.ext.search.push(function(settings, data) {
            let min = $('#minDate').val();
            let max = $('#maxDate').val();
            let date = data[3]; // 4ª coluna (Data)

            if ((min === "" || date >= min) && (max === "" || date <= max)) {
                return true;
            }
            return false;
        });

        $('#minDate, #maxDate').on('change', function() {
            table.draw();
        });
    </script>
@endsection
