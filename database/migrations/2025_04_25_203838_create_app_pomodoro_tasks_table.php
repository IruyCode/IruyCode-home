<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_pomodoro_tasks', function (Blueprint $table) {
            $table->id(); // ID da tarefa
            $table->foreignId('project_id') // ID do projeto (ligado à tabela projetos)
                ->constrained('app_pomodoro_projects')
                ->cascadeOnDelete(); // Se apagar um projeto, apaga as tarefas ligadas
            $table->string('task_name'); // Nome da tarefa
            $table->text('task_description')->nullable(); // Descrição da tarefa (opcional)
            $table->timestamps(); // created_at e updated_at automáticos
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_pomodoro_tasks');
    }
};
