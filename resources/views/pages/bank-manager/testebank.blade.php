<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mobile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden relative min-h-screen">
        <!-- Top bar -->
        <div class="flex justify-between items-center px-4 py-2 border-b">
            <img src="https://via.placeholder.com/32" alt="Avatar" class="rounded-full">
            <span class="text-sm text-gray-500">Setembro ▼</span>
        </div>

        <!-- Saldo -->
        <div class="text-center py-6">
            <p class="text-gray-500 text-sm">Saldo</p>
            <h1 class="text-3xl font-bold text-gray-800">R$ 5.480,35</h1>

            <div class="flex justify-around text-sm mt-4">
                <div class="text-green-600">
                    <p>Receitas</p>
                    <p class="font-bold">R$ 4.586,50</p>
                </div>
                <div class="text-red-500">
                    <p>Despesas</p>
                    <p class="font-bold">R$ 3.678,00</p>
                </div>
            </div>
        </div>

        <!-- Gráfico de categorias -->
        <div class="px-4 py-4">
            <h2 class="text-md font-semibold mb-2">Despesas por categoria</h2>
            <div class="flex items-center gap-4">
                <!-- Placeholder para gráfico -->
                <div
                    class="w-24 h-24 rounded-full border-8 border-blue-400 border-t-yellow-400 border-r-green-500 border-b-red-400">
                </div>
                <div class="text-sm space-y-1">
                    <p><span class="inline-block w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>Mercado - R$ 1.000,00
                    </p>
                    <p><span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>Transporte - R$ 600,00
                    </p>
                    <p><span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>Educação - R$ 300,00</p>
                </div>
            </div>
        </div>

        <!-- Tabela de Transações -->
        <div class="px-4 py-4">
            <h2 class="text-md font-semibold mb-4">Transações do Mês</h2>

            <div class="overflow-x-auto">
                <table id="monthly-transactions" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Data</th>
                            <th class="px-4 py-2 text-left">Descrição</th>
                            <th class="px-4 py-2 text-left">Categoria</th>
                            <th class="px-4 py-2 text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-800">
                        <tr>
                            <td class="px-4 py-2">01/05/2025</td>
                            <td class="px-4 py-2">Supermercado</td>
                            <td class="px-4 py-2">Alimentação</td>
                            <td class="px-4 py-2 text-red-600">- R$ 150,00</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">03/05/2025</td>
                            <td class="px-4 py-2">Freelance</td>
                            <td class="px-4 py-2">Renda Extra</td>
                            <td class="px-4 py-2 text-green-600">+ R$ 500,00</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">07/05/2025</td>
                            <td class="px-4 py-2">Netflix</td>
                            <td class="px-4 py-2">Assinatura</td>
                            <td class="px-4 py-2 text-red-600">- R$ 39,90</td>
                        </tr>
                        <!-- Adicione mais linhas conforme desejar -->
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Footer de navegação estilo app -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-md flex justify-between items-center px-4 h-16 z-50 md:hidden">

            <!-- Botões da esquerda -->
            <div class="flex space-x-6">
                <a href="#" class="text-gray-700 text-sm flex flex-col items-center">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7m-9 2v6m0 0h4m-4 0H7"></path>
                    </svg>
                    Início
                </a>
                <a href="#" class="text-gray-700 text-sm flex flex-col items-center">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1"></path>
                    </svg>
                    Perfil
                </a>
            </div>

            <!-- Botão central flutuante -->
            <div class="absolute left-1/2 transform -translate-x-1/2 -top-6 z-10">
                <button
                    class="bg-blue-600 text-white rounded-full w-14 h-14 shadow-lg border-4 border-white flex items-center justify-center text-3xl">
                    +
                </button>
            </div>

            <!-- Botões da direita -->
            <div class="flex space-x-6">
                <a href="#" class="text-gray-700 text-sm flex flex-col items-center">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Atividades
                </a>
                <a href="#" class="text-gray-700 text-sm flex flex-col items-center">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                    </svg>
                    Mais
                </a>
            </div>
        </div>
        <!-- ./Footer de navegação -->



    </div>
</body>

<!-- jQuery + DataTables (CDN) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#monthly-transactions').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            },
            pageLength: 5,
            lengthChange: false,
            ordering: true,
            info: false
        });
    });
</script>


</html>
