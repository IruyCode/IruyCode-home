<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-aurora flex flex-col min-h-screen relative">

    <header class="fixed top-0 left-0 w-full bg-black bg-opacity-80 backdrop-blur-md shadow-lg z-50">

    </header>

    <main class="flex-grow px-6 pt-20">
        <div class="container mx-auto">
            <!-- Título -->
            <h1 class="text-3xl font-bold text-white mb-8">Dashboard</h1>
    
            <!-- Grid principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                
                <!-- Card de Saldo -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-white">
                    <h2 class="text-lg font-semibold mb-2">Saldo Atual</h2>
                    <p class="text-3xl font-bold text-green-400">€ 1.250,00</p>
                </div>
    
                <!-- Card de Pomodoros -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-white">
                    <h2 class="text-lg font-semibold mb-2">Pomodoros Hoje</h2>
                    <p class="text-3xl font-bold text-blue-400">6 🍅</p>
                </div>
    
                <!-- Card de Tarefas -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-white">
                    <h2 class="text-lg font-semibold mb-2">Tarefas Pendentes</h2>
                    <ul class="mt-3 space-y-1 text-sm">
                        <li class="flex justify-between">
                            <span>Enviar relatório</span>
                            <span class="text-red-400">Urgente</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Estudar Tailwind</span>
                            <span class="text-yellow-400">Hoje</span>
                        </li>
                    </ul>
                </div>
            </div>
    
            <!-- Seção de Gráfico ou Tabela -->
            <section class="mt-12">
                <h2 class="text-xl font-bold text-white mb-4">Últimas Transações</h2>
                <div class="overflow-x-auto bg-gray-800 p-4 rounded-lg shadow">
                    <table class="min-w-full text-sm text-left text-white">
                        <thead class="border-b border-gray-600">
                            <tr>
                                <th class="px-4 py-2">Data</th>
                                <th class="px-4 py-2">Categoria</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2 text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2">27/04/2025</td>
                                <td class="px-4 py-2">Salário</td>
                                <td class="px-4 py-2">Entrada</td>
                                <td class="px-4 py-2 text-right text-green-400">€ 1.200,00</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">26/04/2025</td>
                                <td class="px-4 py-2">Água</td>
                                <td class="px-4 py-2">Saída</td>
                                <td class="px-4 py-2 text-right text-red-400">-€ 45,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    

    <footer class="bg-black text-white py-10 mt-10 border-t border-gray-800">

    </footer>

</body>

</html>
