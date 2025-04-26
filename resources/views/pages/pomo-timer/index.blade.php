@extends('layouts\template')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('spotify.login') }}" class="px-4 py-2 bg-green-500 text-white rounded">
        Conectar com Spotify
    </a>

    <div x-data="pomodoro()"
        class="flex flex-col items-center justify-center mt-4 bg-gray-800 text-white p-8 rounded-lg shadow-md">

        <div class="mt-8 w-full max-w-md bg-gray-700 p-4 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Suas Tarefas</h2>

            <template x-for="task in tasks" :key="task.id">
                <div class="mb-3 p-3 bg-gray-600 rounded flex justify-between items-center">
                    <div>
                        <div class="font-semibold" x-text="task.name"></div>
                        <div class="text-sm text-gray-300">Pomodoros: <span x-text="task.pomodoros"></span></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Selecionar Tarefa -->
        <div class="mb-4 w-full">
            <label for="task_id" class="block mb-2 text-sm font-medium">Selecione a Tarefa</label>
            <select id="task_id" x-model="selectedTaskId"
                class="w-full rounded-md bg-gray-700 border border-gray-600 p-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">-- Escolha uma tarefa --</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                @endforeach
            </select>
        </div>

        <h1 class="text-2xl font-bold mb-2" x-text="modeLabel"></h1>

        <div class="text-6xl font-mono mb-6">
            <span x-text="minutes"></span>:<span x-text="seconds"></span>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mb-4">
            <button @click="startTimer" class="px-4 py-2 bg-green-500 hover:bg-green-600 rounded">Start</button>
            <button @click="pauseTimer" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded">Pause</button>
            <button @click="resetTimer" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded">Reset</button>
        </div>

        <button @click="nextMode" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded">
            Próximo Ciclo
        </button>

        <button onclick="location.href='{{ route('spotify.play') }}'" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md text-white">
            🎵 Iniciar Pomodoro com Música
        </button>

    </div>

    {{-- Criar Projectos --}}
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-900 p-8 text-white">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Criar Novo Projeto</h2>

            <form action="{{ route('pomodoro-timer.projects.store') }}" method="POST" class="space-y-6">

                @csrf

                <div>
                    <label for="nome" class="block mb-2 text-sm font-medium">Nome do Projeto</label>
                    <input type="text" id="nome" name="nome" required
                        class="w-full rounded-md bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-3 text-white">
                </div>

                <div>
                    <label for="descricao" class="block mb-2 text-sm font-medium">Descrição do Projeto</label>
                    <textarea id="descricao" name="descricao" rows="4"
                        class="w-full rounded-md bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-3 text-white"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors p-3 rounded-md font-semibold text-white">
                    Criar Projeto
                </button>
            </form>
        </div>
    </div>

    {{-- Criar Tarefas --}}
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-900 p-8 text-white">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Criar Nova Tarefa</h2>

            <form action="{{ route('pomodoro-timer.tasks.store') }}" method="POST">
                @csrf

                <!-- Selecionar Projeto -->
                <div>
                    <label for="project_id" class="block mb-2 text-sm font-medium">Selecione o Projeto</label>
                    <select id="project_id" name="project_id" required
                        class="w-full rounded-md bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-3 text-white">
                        <option value="">Selecione um projeto</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nome da Tarefa -->
                <div>
                    <label for="task_name" class="block mb-2 text-sm font-medium">Nome da Tarefa</label>
                    <input type="text" id="task_name" name="task_name" required
                        class="w-full rounded-md bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-3 text-white">
                </div>

                <!-- Descrição da Tarefa -->
                <div>
                    <label for="task_description" class="block mb-2 text-sm font-medium">Descrição da Tarefa</label>
                    <textarea id="task_description" name="task_description" rows="4"
                        class="w-full rounded-md bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-3 text-white"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 transition-colors p-3 rounded-md font-semibold text-white">
                    Criar Tarefa
                </button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function pomodoro() {
            return {
                time: 1500,
                timer: null,
                mode: 'pomodoro',
                cycle: 0,
                selectedTaskId: '',

                // Receber as tarefas do backend
                tasks: [
                    @foreach ($tasks as $task)
                        {
                            id: {{ $task->id }},
                            name: "{{ $task->task_name }}",
                            pomodoros: {{ $task->sessions->count() }},
                        },
                    @endforeach
                ],

                // Mostrar o tempo em minutos e segundos formatado
                get minutes() {
                    return String(Math.floor(this.time / 60)).padStart(2, '0');
                },
                get seconds() {
                    return String(this.time % 60).padStart(2, '0');
                },
                get modeLabel() {
                    return {
                        pomodoro: "Pomodoro - Foco 🍅",
                        shortBreak: "Pausa Curta 🧘‍♂️",
                        longBreak: "Pausa Longa 🌴"
                    } [this.mode];
                },

                // Funções do timer
                startTimer() {
                    if (this.timer) return;

                    this.timer = setInterval(() => {
                        if (this.time > 0) {
                            this.time--;
                        } else {
                            this.handlePomodoroFinish();
                        }
                    }, 1000);

                    // ▶️ Começa a playlist do Spotify
                    fetch('/spotify/play');
                },
                pauseTimer() {
                    clearInterval(this.timer);
                    this.timer = null;

                    // ⏸️ Pausa o Spotify também
                    fetch('/spotify/pause');
                },
                resetTimer() {
                    this.pauseTimer();

                    if (this.mode === 'pomodoro') this.time = 1500;
                    else if (this.mode === 'shortBreak') this.time = 300;
                    else if (this.mode === 'longBreak') this.time = 900;
                },
                nextMode() {
                    if (this.mode === 'pomodoro') {
                        this.savePomodoro(); // Salvar antes de mudar de modo
                        this.cycle++;
                        this.mode = (this.cycle % 2 === 0) ? 'longBreak' : 'shortBreak';
                    } else {
                        this.mode = 'pomodoro';
                    }
                    this.resetTimer();

                    // Pausa o som ao mudar o modo (caso não queira música nas pausas)
                    fetch('/spotify/pause');
                },
                handlePomodoroFinish() {
                    if (this.mode === 'pomodoro') {
                        this.savePomodoro();
                    }
                    this.nextMode();

                    fetch("{{ route('spotify.pause') }}");

                },

                // Salvar Pomodoro e atualizar contador
                savePomodoro() {
                    if (!this.selectedTaskId) {
                        alert('Por favor, selecione uma tarefa antes de iniciar!');
                        return;
                    }

                    fetch("{{ route('pomodoro-timer.sessions.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                task_id: this.selectedTaskId,
                            }),
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log('Pomodoro salvo!');

                                // Atualizar o contador de pomodoros na tela
                                const task = this.tasks.find(t => t.id == this.selectedTaskId);
                                if (task) {
                                    task.pomodoros += 1;
                                }
                            } else {
                                console.error('Erro ao salvar pomodoro');
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                        });
                }
            }
        }
    </script>
@endsection
