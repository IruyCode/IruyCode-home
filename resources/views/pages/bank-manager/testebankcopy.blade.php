@extends('layouts.template')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-[#0a2a5c]">
    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex md:flex-col bg-black shadow-lg p-4 rounded-xl m-4 w-56 min-w-max max-w-xs">
        <div class="flex items-center space-x-3 mb-6">
            <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-full w-10 h-10" />
            <span class="font-bold text-lg text-white">Olá, Usuário</span>
        </div>
        <nav class="flex-1">
            <ul class="space-y-4">
                <li>
                    <a href="#" class="flex items-center text-blue-600 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                            <circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none" />
                            <circle cx="12" cy="12" r="2" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        Metas
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3" />
                            <path d="M12 2v20" />
                        </svg>
                        Dívidas
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                            <path d="M2 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                            <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                        </svg>
                        Devedores
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09A1.65 1.65 0 0 0 9 3.09V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        Configuração
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Conteúdo principal -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top bar -->
        <div class="flex justify-between items-center px-4 py-2 border-b bg-black rounded-tr-xl rounded-tl-xl md:sticky md:top-0 md:z-10 w-full mx-auto md:mx-6">
            <div class="flex items-center space-x-3 md:hidden">
                <img src="https://via.placeholder.com/32" alt="Avatar" class="rounded-full" />
                <span class="font-bold text-white">Olá, Usuário</span>
            </div>
            <span class="text-sm text-gray-300">Setembro ▼</span>
        </div>

        <!-- Saldo e Receitas/Despesas -->
        <div class="w-full mx-auto md:mx-6 px-2 md:px-6 py-6 md:py-8 bg-black rounded-xl shadow md:shadow-lg mt-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="text-center md:text-left md:w-1/3">
                    <p class="text-gray-400 text-sm">Saldo</p>
                    <h1 class="text-3xl font-bold text-white">R$ 5.480,35</h1>
                    <div class="flex justify-around md:justify-start md:space-x-8 text-sm mt-4">
                        <div class="text-green-500">
                            <p>Receitas</p>
                            <p class="font-bold">R$ 4.586,50</p>
                        </div>
                        <div class="text-red-400">
                            <p>Despesas</p>
                            <p class="font-bold">R$ 3.678,00</p>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de categorias -->
                <div class="mt-8 md:mt-0 md:w-2/3 flex flex-col md:flex-row md:items-center md:space-x-8">
                    <div class="flex justify-center md:justify-start">
                        <div class="w-24 h-24 rounded-full border-8 border-blue-400 border-t-yellow-400 border-r-green-500 border-b-red-400"></div>
                    </div>
                    <div class="text-sm space-y-1 mt-4 md:mt-0">
                        <h2 class="text-md font-semibold mb-2 text-white">Despesas por categoria</h2>
                        <p><span class="inline-block w-3 h-3 bg-yellow-400 rounded-full mr-2"></span><span class="text-white">Mercado - R$ 1.000,00</span></p>
                        <p><span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span><span class="text-white">Transporte - R$ 600,00</span></p>
                        <p><span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span><span class="text-white">Educação - R$ 300,00</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Transações -->
        <div class="w-full mx-auto md:mx-6 px-2 md:px-6 py-8 flex-1">
            <div class="bg-black rounded-xl shadow p-4">
                <h2 class="text-md font-semibold mb-4 text-white">Transações do Mês</h2>
                <div class="overflow-x-auto">
                    <table id="monthly-transactions" class="min-w-full divide-y divide-gray-700 text-sm">
                        <thead class="bg-gray-900 text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Data</th>
                                <th class="px-4 py-2 text-left">Descrição</th>
                                <th class="px-4 py-2 text-left">Categoria</th>
                                <th class="px-4 py-2 text-left">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="bg-black text-gray-100">
                            <tr>
                                <td class="px-4 py-2">01/05/2025</td>
                                <td class="px-4 py-2">Supermercado</td>
                                <td class="px-4 py-2">Alimentação</td>
                                <td class="px-4 py-2 text-red-400">- R$ 150,00</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">03/05/2025</td>
                                <td class="px-4 py-2">Freelance</td>
                                <td class="px-4 py-2">Renda Extra</td>
                                <td class="px-4 py-2 text-green-500">+ R$ 500,00</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">07/05/2025</td>
                                <td class="px-4 py-2">Netflix</td>
                                <td class="px-4 py-2">Assinatura</td>
                                <td class="px-4 py-2 text-red-400">- R$ 39,90</td>
                            </tr>
                            <!-- Adicione mais linhas conforme desejar -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
