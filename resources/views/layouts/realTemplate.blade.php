<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Empresa</title>
    @vite('resources/css/app.css') <!-- Garante que o Tailwind está funcionando -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Minha Empresa</h1>
        <!-- Botão hambúrguer só no mobile -->
        <button class="md:hidden" @click="open = !open">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <div x-data="{ open: false }" class="flex">
        <!-- Menu lateral (desktop) -->
        <aside class="hidden md:block w-64 bg-white shadow h-screen p-4">
            <nav>
                <ul>
                    <li class="mb-2"><a href="#" class="text-blue-600 font-semibold">Início</a></li>
                    <li class="mb-2"><a href="#">Sobre</a></li>
                    <li class="mb-2"><a href="#">Contato</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Menu mobile (suspenso) -->
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" @click="open = false"></div>
        <aside x-show="open" class="fixed top-0 left-0 w-64 bg-white shadow h-full p-4 z-50 md:hidden" x-transition>
            <button class="mb-4" @click="open = false">Fechar</button>
            <nav>
                <ul>
                    <li class="mb-2"><a href="#" class="text-blue-600 font-semibold">Início</a></li>
                    <li class="mb-2"><a href="#">Sobre</a></li>
                    <li class="mb-2"><a href="#">Contato</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Conteúdo principal -->
        <main class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4">Bem-vindo!</h2>
            <p class="mb-2">Este é um exemplo de layout responsivo com Tailwind CSS.</p>
            <p class="mb-2 md:hidden text-red-600">Você está no modo <b>mobile</b>.</p>
            <p class="hidden md:block text-green-600">Você está no modo <b>desktop</b>.</p>
        </main>
    </div>
</body>

</html>
