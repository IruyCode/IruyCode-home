@extends('layouts\template')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Timer Section -->
            <div class="lg:w-2/3 bg-gray-800 text-white p-6 rounded-lg shadow-md" x-data="pomodoro()">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Pomodoro Timer</h2>
                    <a href="{{ route('spotify.login') }}"
                        class="mt-4 md:mt-0 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Conectar com Spotify
                    </a>
                </div>

                <!-- Tarefa Selecionada -->
                <div class="mb-4">
                    <label for="task_id" class="block mb-2 text-sm font-medium">Selecione a Tarefa</label>
                    <select id="task_id" x-model="selectedTaskId"
                        class="w-full rounded-md bg-gray-700 border border-gray-600 p-3">
                        <option value="">-- Escolha uma tarefa --</option>
                        @foreach ($tasks as $task)
                            <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Timer Display -->
                <div class="text-center mb-6">
                    <h1 class="text-xl font-bold mb-2" x-text="modeLabel"></h1>
                    <div class="text-6xl font-mono">
                        <span x-text="minutes"></span>:<span x-text="seconds"></span>
                    </div>
                </div>

                <!-- Timer Controls -->
                <div class="flex justify-center gap-4 mb-4">
                    <button @click="startTimer" class="px-4 py-2 bg-green-500 hover:bg-green-600 rounded">Start</button>
                    <button @click="pauseTimer" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded">Pause</button>
                    <button @click="resetTimer" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded">Reset</button>
                </div>

                <div class="text-center mb-6">
                    <button @click="nextMode" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded">Próximo Ciclo</button>
                </div>

                <div class="text-center">
                    <button onclick="location.href='{{ route('spotify.play') }}'"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md">
                        🎵 Iniciar Pomodoro com Música
                    </button>
                </div>
            </div>

            <!-- Tasks Sidebar -->
            <div class="lg:w-1/3 space-y-6">
                <!-- Lista de Tarefas -->
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
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

                <!-- Criar Projeto -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Criar Novo Projeto</h2>
                    <form action="{{ route('pomodoro-timer.projects.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" id="nome" name="nome" placeholder="Nome do Projeto" required
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                        <textarea id="descricao" name="descricao" rows="3" placeholder="Descrição do Projeto"
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white"></textarea>
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 p-3 rounded font-semibold text-white">
                            Criar Projeto
                        </button>
                    </form>
                </div>

                <!-- Criar Tarefa -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Criar Nova Tarefa</h2>
                    <form action="{{ route('pomodoro-timer.tasks.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <select id="project_id" name="project_id" required
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                            <option value="">Selecione um projeto</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="task_name" name="task_name" placeholder="Nome da Tarefa" required
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                        <textarea id="task_description" name="task_description" rows="3" placeholder="Descrição da Tarefa"
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white"></textarea>
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 p-3 rounded font-semibold text-white">
                            Criar Tarefa
                        </button>
                    </form>
                </div>
            </div>
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
