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

    {{-- <style>
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
    </style> --}}

</head>

<body x-data="{ menuAberto: false, bloco: 'dashboard' }" class="bg-aurora flex flex-col min-h-screen relative">

    <!-- Navbar -->
    <nav class="bg-white border-gray-200 dark:bg-black fixed top-0 left-0 w-full z-50 shadow">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo -->
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
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
                <img src="{{ asset($logo) }}" class="h-16 md:h-17 drop-shadow-lg" alt="Logo" />
            </a>
            <!-- Ações à direita (exemplo: idioma) -->
            <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="inline-flex items-center font-medium justify-center px-4 py-2 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-5 h-5 rounded-full me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3900 3900"><path fill="#b22234" d="M0 0h7410v3900H0z"/><path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff" stroke-width="300"/><path fill="#3c3b6e" d="M0 0h2964v2100H0z"/></svg>
                    Português
                </button>
                <!-- Botão hamburguer -->
                <button @click="menuAberto = !menuAberto" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-language" aria-expanded="false">
                    <span class="sr-only">Abrir menu principal</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <!-- Menu links -->
            <div x-show="menuAberto" x-transition class="w-full md:hidden mt-4" @click.away="menuAberto = false">
                <ul class="flex flex-col font-medium p-4 border border-gray-100 rounded-lg bg-black space-y-2">
                    <li>
                        <a href="#" class="block py-2 px-3 text-blue-600 bg-black rounded-sm" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#sobre" class="block py-2 px-3 text-white bg-black rounded-sm hover:text-blue-600">Sobre</a>
                    </li>
                    <li>
                        <a href="#projetos" class="block py-2 px-3 text-white bg-black rounded-sm hover:text-blue-600">Projetos</a>
                    </li>
                    <li>
                        <a href="#contactos" class="block py-2 px-3 text-white bg-black rounded-sm hover:text-blue-600">Contatos</a>
                    </li>
                </ul>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-language">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-black md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-black dark:bg-black md:dark:bg-black dark:border-gray-700">
                    <li>
                        <a href="#" class="block py-2 px-3 text-blue-600 bg-black rounded-sm md:bg-transparent md:text-blue-600 md:p-0 md:dark:text-blue-400" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#sobre" class="block py-2 px-3 md:p-0 text-white bg-black rounded-sm hover:text-blue-600 md:hover:bg-transparent md:hover:text-blue-600 dark:text-white md:dark:hover:text-blue-400 dark:hover:bg-black dark:hover:text-blue-400 md:dark:hover:bg-transparent dark:border-gray-700">Sobre</a>
                    </li>
                    <li>
                        <a href="#projetos" class="block py-2 px-3 md:p-0 text-white bg-black rounded-sm hover:text-blue-600 md:hover:bg-transparent md:hover:text-blue-600 dark:text-white md:dark:hover:text-blue-400 dark:hover:bg-black dark:hover:text-blue-400 md:dark:hover:bg-transparent dark:border-gray-700">Projetos</a>
                    </li>
                    <li>
                        <a href="#contactos" class="block py-2 px-3 md:p-0 text-white bg-black rounded-sm hover:text-blue-600 md:hover:bg-transparent md:hover:text-blue-600 dark:text-white md:dark:hover:text-blue-400 dark:hover:bg-black dark:hover:text-blue-400 md:dark:hover:bg-transparent dark:border-gray-700">Contatos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
    <main class="flex-grow px-6 pt-27">
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

    @yield('scripts')

    <!-- Scripts únicos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>
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
                    table.column(0).search('').draw();
                } else {
                    table.column(0).search('^' + selected + '$', true, false).draw();
                }
            });
        });
    </script>

</body>

</html>
