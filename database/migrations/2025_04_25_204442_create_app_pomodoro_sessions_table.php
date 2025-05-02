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
        Schema::create('app_pomodoro_sessions', function (Blueprint $table) {
            $table->id(); // ID da sessão Pomodoro
            $table->foreignId('task_id') // ID do projeto (ligado à tabela projetos)
                ->constrained('app_pomodoro_tasks')
                ->cascadeOnDelete(); // Se apagar o projeto, apaga as sessões relacionadas
            $table->timestamp('completed_at'); // Quando a sessão foi completada
            $table->timestamps(); // created_at e updated_at automáticos
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_pomodoro_sessions');
    }
};
