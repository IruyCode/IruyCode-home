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

    <style>
        /* Corrige textos do DataTables no modo escuro */
        .dataTables_wrapper {
            color: #f3f4f6;
            /* text-gray-100 */
        }

        .dataTables_paginate .paginate_button {
            color: #f3f4f6 !important;
            background-color: transparent !important;
            border: 1px solid #4b5563;
            /* gray-600 */
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #3b82f6 !important;
            /* blue-500 */
            color: white !important;
        }
    </style>

</head>

<body class="bg-aurora flex flex-col min-h-screen relative">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full bg-black bg-opacity-80 backdrop-blur-md shadow-lg z-50">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">

            @php
                $path = request()->path(); // pega a URL tipo 'bank-manager', 'health-meal', etc

                if (str_starts_with($path, 'bank-manager')) {
                    $logo = 'assets/imgs/logos/logo_bank_manager.png';
                } elseif (str_starts_with($path, 'health-meal')) {
                    $logo = 'assets/imgs/logos/logo_health_meal.png';
                } elseif (str_starts_with($path, 'pomodoro-timer')) {
                    $logo = 'assets/imgs/logos/logo_pomodoro.png';
                } else {
                    $logo = 'assets/imgs/logos/logo_iruycode_principal.png';
                }
            @endphp

            <!-- Logo -->
            <a href="#" class="text-white text-2xl font-bold flex items-center">
                <img src="{{ asset($logo) }}" alt="Logo" class="h-20 mr-2">
            </a>

            <!-- Menu Desktop -->
            <nav>
                <ul class="hidden md:flex space-x-8 items-center">

                    <li><a href="#sobre" class="text-white hover:text-blue-400 transition-colors">IruyCode</a></li>

                    <!-- Dropdown Projetos -->
                    <li x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                        <button class="text-white hover:text-blue-400 transition-colors">Projetos</button>

                        <!-- Dropdown -->
                        <ul x-show="open" x-transition
                            class="absolute bg-black bg-opacity-90 text-white mt-2 py-2 w-48 rounded shadow-lg z-50">
                            <li>
                                <a href="{{ route('health-meal.index') }}"
                                    class="block px-4 py-2 hover:bg-blue-600 hover:text-white">Health Meal</a>
                            </li>
                            <li>
                                <a href="{{ route('bank-manager.index') }}"
                                    class="block px-4 py-2 hover:bg-blue-600 hover:text-white">Bank Manager</a>
                            </li>
                            <li>
                                <a href="{{ route('pomodoro-timer.index') }}"
                                    class="block px-4 py-2 hover:bg-blue-600 hover:text-white">Pomodoro Timer</a>
                            </li>
                        </ul>
                    </li>


                    <li><a href="#" class="text-white hover:text-blue-400 transition-colors">Criar Refeicoes</a>
                    </li>
                    <li><a href="#contactos" class="text-white hover:text-blue-400 transition-colors">Portifolio</a>
                    </li>
                </ul>
            </nav>

            <!-- Botão Menu Mobile -->
            <button id="menu-btn" class="md:hidden text-white focus:outline-none" aria-label="Abrir menu">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Menu Mobile -->
            <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-black bg-opacity-90 z-40"
                x-data="{ openProjetos: false }">
                <ul class="text-center py-4">
                    <!-- Projetos com submenus -->
                    <li class="py-2">
                        <button @click="openProjetos = !openProjetos"
                            class="text-white hover:text-blue-400 w-full text-center px-4 py-2">
                            Projetos
                        </button>

                        <ul x-show="openProjetos" x-transition>
                            <li><a href="#" class="block px-6 py-1 text-blue-400">Health Meal</a></li>
                            <li><span class="block px-6 py-1 text-gray-500">Em breve 1</span></li>
                            <li><span class="block px-6 py-1 text-gray-500">Em breve 2</span></li>
                        </ul>
                    </li>
                    <li class="py-2"><a href="#sobre" class="text-white hover:text-blue-400">Sobre</a></li>
                    <li class="py-2"><a href="#linguagens" class="text-white hover:text-blue-400">Linguagens</a></li>
                    <li class="py-2"><a href="#contactos" class="text-white hover:text-blue-400">Contatos</a></li>
                </ul>
            </div>


        </div>
    </header>

    <!-- Pre-loader -->
    {{-- <div x-data="{ loading: true, stage: 1 }" x-init="setTimeout(() => stage = 2, 3000);
    setTimeout(() => loading = false, 6000);"
        class="fixed inset-0 bg-black z-50 flex items-center justify-center" x-show="loading"
        x-transition:leave="transition-opacity duration-1000" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <!-- Estágio 1: small logo responsiva -->
        <template x-if="stage === 1">
            <img src="{{ asset('assets/videos/small_logo.gif') }}" alt="Loading..."
                class="w-[60vw] md:w-[35vw] lg:w-[25vw] h-auto">
        </template>

        <!-- Estágio 2: normal logo responsiva -->
        <template x-if="stage === 2">
            <img src="{{ asset('assets/videos/gift_health_meal.gif') }}" alt="Logo final"
                class="w-[75vw] md:w-[50vw] lg:w-[35vw] h-auto transition-all duration-1000">
        </template>
    </div> --}}

    <!-- Main content -->
    <main class="flex-grow px-6 pt-20">
        <!-- Aqui vão as páginas que mudam -->
        @yield('content')
    </main>


    <footer class="bg-black text-white py-10 mt-10 border-t border-gray-800">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-left">

            <!-- Logo e Descrição -->
            <div>
                <a href="#" class="flex items-center justify-center ">
                    <img src="{{ asset('assets\imgs\logos\logo_iruycode_principal.png') }}" alt="Logo"
                        class="h-12 w-auto mr-2 my-2">
                </a>
                <p class="text-gray-400">Desenvolvendo soluções com paixão e qualidade. Entre em contato para colaborar
                    em projetos incríveis.</p>
            </div>

            <!-- Navegação -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Navegação</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#projetos" class="hover:text-white">Projetos</a></li>
                    <li><a href="#sobre" class="hover:text-white">Sobre</a></li>
                    <li><a href="#linguagens" class="hover:text-white">Linguagens</a></li>
                    <li><a href="#contactos" class="hover:text-white">Contatos</a></li>
                </ul>
            </div>

            <!-- Redes Sociais -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Redes Sociais</h4>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                </div>
            </div>
        </div>

        <!-- Direitos autorais -->
        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Minha Empresa. Todos os direitos reservados.
        </div>
    </footer>

    @vite('resources/js/app.js')

    <!-- JavaScript para Menu Mobile -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    @yield('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <script>
        $(document).ready(function() {
            const table = $('#categoryTable').DataTable({
                paging: true,
                responsive: true,
            });

            $('#typeFilter').on('change', function() {
                const selected = $(this).val();
                if (selected === "") {
                    table.column(0).search('').draw(); // <-- Corrige a coluna
                } else {
                    table.column(0).search('^' + selected + '$', true, false).draw();
                }
            });
        });
    </script>


</body>

</html>
