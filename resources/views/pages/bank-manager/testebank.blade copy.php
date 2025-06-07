@extends('layouts.template')

@section('content')

    <!-- Div principal -->
    <div class="min-h-screen flex flex-col md:flex-row" x-data="{ bloco: 'dashboard' }">

        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex md:flex-col bg-black shadow-lg p-4 rounded-xl m-4 w-56 min-w-max max-w-xs">
            <div class="flex items-center space-x-3 mb-6">
                <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-full w-10 h-10" />
                <span class="font-bold text-lg text-white">Olá, Usuário</span>
            </div>
            <nav class="flex-1">
                <ul class="space-y-4">
                    <li>
                        <a href="#" @click.prevent="bloco = 'dashboard'"
                            :class="bloco === 'dashboard' ? 'text-blue-400 font-bold' : 'text-white'"
                            class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <rect x="4" y="4" width="16" height="16" rx="4" stroke="currentColor"
                                    stroke-width="2" fill="none" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="bloco = 'metas'"
                            :class="bloco === 'metas' ? 'text-blue-400 font-bold' : 'text-white'"
                            class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                                <circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                                <circle cx="12" cy="12" r="2" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                            </svg>
                            Metas
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="bloco = 'dividas'"
                            :class="bloco === 'dividas' ? 'text-blue-400 font-bold' : 'text-white'"
                            class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3" />
                                <path d="M12 2v20" />
                            </svg>
                            Dívidas
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="bloco = 'devedores'"
                            :class="bloco === 'devedores' ? 'text-blue-400 font-bold' : 'text-white'"
                            class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="9" cy="7" r="4" />
                                <path d="M17 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                                <path d="M2 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                                <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                            </svg>
                            Devedores
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="bloco = 'configuracao'"
                            :class="bloco === 'configuracao' ? 'text-blue-400 font-bold' : 'text-white'"
                            class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09A1.65 1.65 0 0 0 9 3.09V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                            Configuração
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Conteúdo principal -->
        <div class="flex-1 flex flex-col min-h-screen px-[2%] mt-4">
            <!-- Top bar -->
            <div
                class="flex justify-between items-center px-0 py-2 border-b bg-black rounded-tr-xl rounded-tl-xl md:sticky md:top-0 md:z-20 w-full pl-4 relative z-20">
                <div class="flex items-center space-x-3 md:hidden">
                    <img src="https://via.placeholder.com/32" alt="Avatar" class="rounded-full" />
                    <span class="font-bold text-white">Olá, Usuário</span>
                </div>
                <span class="text-sm text-gray-300">Setembro ▼</span>
            </div>

            <!-- Saldo e Receitas/Despesas + Tabela de Transações (Dashboard) -->
            <template x-if="bloco === 'dashboard'" x-data="dashboard">
                <div class="flex flex-col">
                    <!-- Dashboard Financeiro Unificado -->
                    <div class="w-full py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg -mt-6 relative z-10">
                        <!-- Filtros -->
                        <div
                            class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 md:gap-8 px-1 md:px-6 pb-4 border-b border-gray-800">
                            <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full md:w-auto">
                                <div>
                                    <label class="block text-gray-400 text-xs mb-1">Data início</label>
                                    <input type="date"
                                        class="rounded bg-gray-800 text-white px-2 py-1 border border-gray-700 w-full"
                                        x-model="dataInicio">
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-xs mb-1">Data fim</label>
                                    <input type="date"
                                        class="rounded bg-gray-800 text-white px-2 py-1 border border-gray-700 w-full"
                                        x-model="dataFim">
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-xs mb-1">Categoria</label>
                                    <select class="rounded bg-gray-800 text-white px-2 py-1 border border-gray-700 w-full"
                                        x-model="categoriaFiltro">
                                        <option value="">Todas</option>
                                        <option value="mercado">Mercado</option>
                                        <option value="transporte">Transporte</option>
                                        <option value="educacao">Educação</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-xs mb-1">Tipo</label>
                                    <select class="rounded bg-gray-800 text-white px-2 py-1 border border-gray-700 w-full"
                                        x-model="tipoFiltro">
                                        <option value="">Todos</option>
                                        <option value="income">Receita</option>
                                        <option value="expense">Despesa</option>
                                    </select>
                                </div>
                            </div>
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700 transition w-full md:w-auto mt-2 md:mt-0"
                                @click="filtrarTransacoes">Filtrar</button>
                        </div>

                        <!-- Resumo e Gráfico -->
                        <div class="flex flex-col md:flex-row md:items-stretch md:justify-between pt-6 gap-4 md:gap-8">
                            <!-- Coluna 1: Resumo -->
                            <div
                                class="md:w-1/2 w-full bg-black rounded-xl shadow p-2 md:p-6 flex flex-col justify-between min-h-[22rem] max-h-[28rem] overflow-hidden">
                                <div class="text-center md:text-left">
                                    <h3 class="text-white text-lg font-bold">Resumo Financeiro</h3>
                                    <p class="text-gray-400 text-sm">Saldo</p>
                                    <h1 class="text-3xl font-bold text-white">R$ 5.480,35</h1>
                                    <div
                                        class="flex flex-col md:flex-row md:justify-start justify-center md:space-x-8 text-sm mt-4 items-center">
                                        <div class="text-green-500">
                                            <p>Receitas</p>
                                            <p class="font-bold">R$ 4.586,50</p>
                                        </div>
                                        <div class="text-red-400 mt-2 md:mt-0">
                                            <p>Despesas</p>
                                            <p class="font-bold">R$ 3.678,00</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center md:text-left">
                                    <p class="text-gray-400 text-sm">Despesas Fixas</p>
                                    <ul class="list-disc pl-6 text-white text-sm inline-block md:block text-left">
                                        <li>Aluguel: R$ 1.200,00</li>
                                        <li>Internet: R$ 120,00</li>
                                        <li>Academia: R$ 90,00</li>
                                    </ul>
                                </div>
                                <div class="text-center md:text-left">
                                    <p class="text-gray-400 text-sm">Média de Gastos Mensais</p>
                                    <div class="flex flex-col md:flex-row items-center gap-2 justify-center md:justify-start">
                                        <span class="text-white font-bold">R$ 3.500,00</span>
                                        <span class="text-xs px-2 py-1 rounded bg-green-700 text-green-200">↓ 5% vs mês
                                            anterior</span>
                                    </div>
                                </div>
                                <!-- Fluxo de Caixa -->
                                <div class="flex flex-col md:flex-row md:space-x-8 mt-4 text-center md:text-left">
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-xs">Entradas no período</p>
                                        <p class="text-green-400 font-bold text-lg">R$ 2.000,00</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-xs">Saídas no período</p>
                                        <p class="text-red-400 font-bold text-lg">R$ 1.500,00</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-xs">Saldo do período</p>
                                        <p class="text-white font-bold text-lg">R$ 500,00</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Coluna 2: Gráfico de categorias -->
                            <div
                                class="md:w-1/2 w-full bg-black flex items-center justify-center min-h-[22rem] max-h-[28rem] pb-4 overflow-hidden">
                                <canvas id="expenseChart" class="w-full h-full aspect-square"
                                    style="max-width:100%;max-height:100%"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable de Transações -->
                    <div class="w-full py-8 flex-1">
                        <div class="bg-black rounded-xl shadow p-2 md:p-4">
                            <h2 class="text-md font-semibold mb-4 text-white">Transações do Mês</h2>
                            <div class="overflow-x-auto">
                                <table id="monthly-transactions" class="min-w-full divide-y divide-gray-700 text-sm">
                                    <thead class="bg-gray-900 text-gray-200">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Data</th>
                                            <th class="px-4 py-2 text-left">Descrição</th>
                                            <th class="px-4 py-2 text-left">Categoria</th>
                                            <th class="px-4 py-2 text-left">Tipo</th>
                                            <th class="px-4 py-2 text-left">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-black text-gray-100">
                                        <!-- Aqui você renderiza as transações filtradas -->
                                        <tr>
                                            <td class="px-4 py-2">01/05/2025</td>
                                            <td class="px-4 py-2">Supermercado</td>
                                            <td class="px-4 py-2">Alimentação</td>
                                            <td class="px-4 py-2">Despesa</td>
                                            <td class="px-4 py-2 text-red-400">- R$ 150,00</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2">03/05/2025</td>
                                            <td class="px-4 py-2">Freelance</td>
                                            <td class="px-4 py-2">Renda Extra</td>
                                            <td class="px-4 py-2">Receita</td>
                                            <td class="px-4 py-2 text-green-500">+ R$ 500,00</td>
                                        </tr>
                                        <!-- ... -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Bloco Metas -->
            <template x-if="bloco === 'metas'">
                <div class="w-full px-0 py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg pl-4 -mt-6 relative z-10">
                    <div class="pt-8">
                        <h2 class="text-2xl font-bold mb-4 text-white">Metas</h2>
                        <ul class="list-disc pl-6 text-white">
                            <li>Meta 1: Economizar R$ 1.000,00</li>
                            <li>Meta 2: Quitar cartão de crédito</li>
                            <li>Meta 3: Investir em educação financeira</li>
                        </ul>
                    </div>
                </div>
            </template>

            <!-- Bloco Dívidas -->
            <template x-if="bloco === 'dividas'">
                <div class="w-full px-0 py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg pl-4 -mt-6 relative z-10">
                    <div class="pt-8">
                        <h2 class="text-2xl font-bold mb-4 text-white">Dívidas</h2>
                        <ul class="list-disc pl-6 text-white">
                            <li>Cartão de crédito: R$ 2.000,00</li>
                            <li>Empréstimo pessoal: R$ 5.000,00</li>
                            <li>Financiamento: R$ 20.000,00</li>
                        </ul>
                    </div>
                </div>
            </template>

            <!-- Bloco Devedores -->
            <template x-if="bloco === 'devedores'">
                <div class="w-full px-0 py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg pl-4 -mt-6 relative z-10">
                    <div class="pt-8">
                        <h2 class="text-2xl font-bold mb-4 text-white">Devedores</h2>
                        <ul class="list-disc pl-6 text-white">
                            <li>João: R$ 300,00</li>
                            <li>Maria: R$ 150,00</li>
                            <li>Carlos: R$ 500,00</li>
                        </ul>
                    </div>
                </div>
            </template>

            <!-- Bloco Configuração -->
            <template x-if="bloco === 'configuracao'">
                <div class="w-full px-0 py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg pl-4 -mt-6 relative z-10">
                    <div class="pt-8">
                        <h2 class="text-2xl font-bold mb-4 text-white">Configuração</h2>
                        <ul class="list-disc pl-6 text-white">
                            <li>Alterar senha</li>
                            <li>Notificações</li>
                            <li>Preferências de idioma</li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
        <!-- Fim do conteúdo principal -->

        <!-- Footer de navegação estilo app (só mobile) -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex items-center h-16 z-50 md:hidden px-0">
            <a href="#" @click.prevent="bloco = 'metas'"
                :class="bloco === 'metas' ? 'text-blue-600 font-bold' : 'text-gray-700'"
                class="flex flex-col items-center justify-center flex-1 text-xs py-1">
                <!-- Ícone de alvo/metas -->
                <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <circle cx="12" cy="12" r="2" stroke="currentColor" stroke-width="2"
                        fill="none" />
                </svg>
                Metas
            </a>
            <a href="#" @click.prevent="bloco = 'dividas'"
                :class="bloco === 'dividas' ? 'text-blue-600 font-bold' : 'text-gray-700'"
                class="flex flex-col items-center justify-center flex-1 text-xs py-1">
                <!-- Ícone de dívidas (cifrão) -->
                <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3" />
                    <path d="M12 2v20" />
                </svg>
                Dívidas
            </a>
            <!-- Botão central flutuante -->
            <div class="relative flex-1 flex flex-col items-center justify-center">
                <button
                    class="bg-blue-600 text-white rounded-full w-16 h-16 shadow-lg border-4 border-white flex items-center justify-center text-3xl absolute -top-10 left-1/2 -translate-x-1/2 z-10">+</button>
            </div>
            <a href="#" @click.prevent="bloco = 'devedores'"
                :class="bloco === 'devedores' ? 'text-blue-600 font-bold' : 'text-gray-700'"
                class="flex flex-col items-center justify-center flex-1 text-xs py-1">
                <!-- Ícone de devedores (pessoas) -->
                <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="4" />
                    <path d="M17 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                    <path d="M2 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                    <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                </svg>
                Devedores
            </a>
            <a href="#" @click.prevent="bloco = 'configuracao'"
                :class="bloco === 'configuracao' ? 'text-blue-600 font-bold' : 'text-gray-700'"
                class="flex flex-col items-center justify-center flex-1 text-xs py-1">
                <!-- Ícone de configuração (engrenagem) -->
                <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09A1.65 1.65 0 0 0 9 3.09V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
                Configuração
            </a>
        </div>
        <!-- ./Footer de navegação -->
    </div>
    <!-- Fim do Div principal -->
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let expenseChart = null;

        function initChart() {
            const ctx = document.getElementById('expenseChart');
            if (!ctx) return;

            if (expenseChart) {
                expenseChart.destroy();
            }

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
                    responsive: true,
                    maintainAspectRatio: false,
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
                    },
                    layout: {
                        padding: 0
                    }
                }
            };

            expenseChart = new Chart(ctx, config);
        }

        // Inicializa o gráfico quando a página carrega
        document.addEventListener("DOMContentLoaded", initChart);

        // Componente Alpine.js para o dashboard
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                init() {
                    this.$watch('bloco', (value) => {
                        if (value === 'dashboard') {
                            setTimeout(initChart, 100);
                        }
                    });
                }
            }));
        });
    </script>
    <!--
            Análise: O uso do Chart.js é uma das melhores opções para gráficos em dashboards Laravel + Blade, pois é leve, responsivo, fácil de integrar e customizar. Alternativas modernas incluem ApexCharts (ótimo para dashboards interativos), ECharts (mais robusto), ou até componentes Vue/React se o projeto evoluir para SPA. Para Blade puro, Chart.js é simples, eficiente e tem ótima documentação. -->
@endsection

