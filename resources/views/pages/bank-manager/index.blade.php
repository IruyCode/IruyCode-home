@extends('layouts/template')

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
                                <td class="px-6 py-4">{{ $transaction->operationCategory->name ?? 'Sem categoria' }}
                                </td>
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




        <!-- Dashboard das Dívidas -->
        <div x-data="{ open: false }" class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded p-6">
            <!-- Botão sempre visível -->
            <button @click="open = !open"
                class="w-full text-left text-white font-semibold bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
                📊 Dashboard das Dívidas
            </button>
            <div x-show="open" x-transition class="mt-4">
                <!--Dashboard das Dívidas-->
                <div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded p-6">
                    <h2 class="text-2xl font-bold mb-4">💳 Dívidas Parceladas</h2>

                    @foreach ($debts as $debt)
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-xl font-semibold">{{ $debt->name }}</h3>
                            <p class="text-gray-600">{{ $debt->description }}</p>
                            <p><strong>Total:</strong> R$ {{ number_format($debt->total_amount, 2, ',', '.') }} |
                                <strong>Parcelas:</strong> {{ $debt->installments }}x
                            </p>

                            <table class="w-full mt-3 text-sm border">
                                <thead>
                                    <tr class="bg-gray-100 text-left">
                                        <th class="p-2">#</th>
                                        <th class="p-2">Valor</th>
                                        <th class="p-2">Vencimento</th>
                                        <th class="p-2">Status</th>
                                        <th class="p-2">Pago em</th>
                                        <th class="p-2">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($debt->installmentsList as $installment)
                                        <tr class="border-t">
                                            <td class="p-2">{{ $installment->installment_number }}</td>
                                            <td class="p-2">R$ {{ number_format($installment->amount, 2, ',', '.') }}
                                            </td>
                                            <td class="p-2">
                                                {{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="p-2">
                                                @if ($installment->paid_at)
                                                    <span class="text-green-600 font-bold">Pago</span>
                                                @else
                                                    <span class="text-red-600 font-bold">Pendente</span>
                                                @endif
                                            </td>
                                            <td class="p-2">
                                                @if ($installment->paid_at)
                                                    {{ \Carbon\Carbon::parse($installment->paid_at)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="p-2">
                                                @if (!$installment->paid_at)
                                                    <form
                                                        action="{{ route('debt-installments.markAsPaid', $installment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Marcar
                                                            como pago</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
                <!-- Tabela de Dívidas-->
                <div class="container mx-auto py-6">
                    <h2 class="text-2xl font-semibold mb-4">Gestão de Dívidas</h2>

                    <table id="debt-table" class="table-auto w-full border bg-white text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Total</th>
                                <th>Parcelas Totais</th>
                                <th>Pagas</th>
                                <th>Pendentes</th>
                                <th>Total Pago</th>
                                <th>Valor Restante</th>
                                <th>Parcelas a Pagar</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($debts as $debt)
                                @php
                                    $paidInstallments = $debt->installmentsList->whereNotNull('paid_at');
                                    $pendingInstallments = $debt->installmentsList->whereNull('paid_at');
                                    $amountPaid = $paidInstallments->sum('amount');
                                @endphp
                                <tr class="border-b">
                                    <td>{{ $debt->name }}</td>
                                    <td>{{ $debt->description }}</td>
                                    <td>€ {{ number_format($debt->total_amount, 2) }}</td>
                                    <td>{{ $debt->installmentsList->count() }}</td>
                                    <td>{{ $paidInstallments->count() }}</td>
                                    <td>{{ $pendingInstallments->count() }}</td>
                                    <td>€ {{ number_format($amountPaid, 2) }}</td>
                                    <td>€ {{ number_format($debt->total_amount - $amountPaid, 2) }}</td>
                                    <td>
                                        <form action="{{ route('debt-installments.bulkMarkAsPaid', $debt->id) }}"
                                            method="POST" class="flex space-x-2">
                                            @csrf
                                            <input type="number" name="quantity" min="1"
                                                max="{{ $pendingInstallments->count() }}"
                                                class="border px-2 py-1 rounded w-16 text-sm" placeholder="0" required>
                                    </td>
                                    <td>
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-white text-sm">
                                            Pagar
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">📥 Gestão de Devedores</h1>

            <table class="w-full table-auto border text-sm bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">Nome</th>
                        <th class="px-3 py-2">Descrição</th>
                        <th class="px-3 py-2">Valor</th>
                        <th class="px-3 py-2">Data Original</th>
                        {{-- <th class="px-3 py-2">Data Atual</th> --}}
                        {{-- <th class="px-3 py-2">Histórico</th> --}}
                        {{-- <th class="px-3 py-2">Status</th> --}}
                        {{-- <th class="px-3 py-2">Ações</th> --}}
                    </tr>
                </thead>
                <tbody>

                    {{-- @dd($debtors); --}}
                    @foreach ($debtors as $debtor)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $debtor->name }}</td>
                            <td class="px-3 py-2">{{ $debtor->description }}</td>
                            <td class="px-3 py-2">€ {{ number_format($debtor->amount, 2, ',', '.') }}</td>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($debtor->due_date)->format('d/m/Y') }}
                            </td>
                            {{-- <td class="px-3 py-2">{{ \Carbon\Carbon::parse($debtor->edits->new_due_date)->format('d/m/Y') }}
                            </td> --}}
                            {{-- <td class="px-3 py-2">
                                @if ($debtor->edits->count())
                                    <ul class="list-disc ml-5 text-xs text-gray-700">
                                        @foreach ($debtor->edits as $edit)
                                            <li>
                                                {{ $edit->reason }} ({{ $edit->updated_at->format('d/m/Y') }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400 italic">Nenhuma alteração</span>
                                @endif
                            </td> --}}
                            {{-- <td class="px-3 py-2">
                                @if ($debtor->is_paid)
                                    <span class="text-green-600 font-bold">Recebido</span>
                                @else
                                    <span class="text-red-600 font-bold">Pendente</span>
                                @endif
                            </td> --}}
                            {{-- <td class="px-3 py-2 space-y-2">
                                @if (!$debtor->is_paid)
                                    <!-- Form editar -->
                                    <form action="{{ route('debtors.edit', $debtor->id) }}" method="GET">
                                        <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">Editar</button>
                                    </form>

                                    <!-- Form marcar como recebido -->
                                    <form action="{{ route('debtors.markAsPaid', $debtor->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">Receber</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Ações desabilitadas</span>
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- <div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow rounded">
            <h2 class="text-xl font-bold mb-4">✏️ Editar Devedor</h2>

            <form action="{{ route('debtors.update', $debtor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold">Nome:</label>
                    <input type="text" name="name" value="{{ $debtor->name }}"
                        class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Novo Valor (€):</label>
                    <input type="number" step="0.01" name="amount" value="{{ $debtor->amount }}"
                        class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Nova Data Prevista:</label>
                    <input type="date" name="current_due_date"
                        value="{{ $debtor->current_due_date->format('Y-m-d') }}" class="w-full border p-2 rounded"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Motivo da Alteração:</label>
                    <textarea name="reason" class="w-full border p-2 rounded" required></textarea>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('debtors.index') }}" class="text-gray-500 hover:underline">← Cancelar</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div> --}}



        <!-- Form para criar uma nova meta -->
        <div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded p-6">
            <h2 class="text-2xl font-bold mb-4">🎯 Nova Meta Financeira</h2>

            <form action="{{ route('financial-goals.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nome da Meta</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Descrição</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="target_amount" class="block text-gray-700 font-medium mb-2">Valor Objetivo (€)</label>
                    <input type="number" name="target_amount" id="target_amount" step="0.01" required
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="deadline" class="block text-gray-700 font-medium mb-2">Data Limite</label>
                    <input type="date" name="deadline" id="deadline" required
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2 rounded w-full">
                    Salvar Meta
                </button>
            </form>
        </div>


        <div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">🎯 Metas Financeiras</h2>

            @foreach ($goals as $goal)
                @php
                    $percentage = $goal->target_amount > 0 ? ($goal->current_amount / $goal->target_amount) * 100 : 0;
                    $remaining = $goal->target_amount - $goal->current_amount;
                @endphp

                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $goal->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $goal->description }}</p>
                    <p class="mt-1 text-gray-700">
                        💰 Meta: <strong>€{{ number_format($goal->target_amount, 2) }}</strong><br>
                        📆 Prazo: <strong>{{ \Carbon\Carbon::parse($goal->deadline)->format('d/m/Y') }}</strong><br>
                        📈 Progresso: <strong>€{{ number_format($goal->current_amount, 2) }}
                            ({{ number_format($percentage, 1) }}%)
                        </strong><br>
                        🧮 Faltam: <strong>€{{ number_format($remaining, 2) }}</strong>
                    </p>

                    <div class="w-full bg-gray-300 rounded h-4 mt-2">
                        <div class="bg-green-600 h-4 rounded" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                </div>
            @endforeach

            @if ($goals->isEmpty())
                <p class="text-gray-500">Nenhuma meta definida ainda.</p>
            @endif
        </div>



    </div>








    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#debt-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json'
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


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
