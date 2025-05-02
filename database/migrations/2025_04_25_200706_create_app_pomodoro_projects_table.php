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
        Schema::create('app_pomodoro_projects', function (Blueprint $table) {
            $table->id(); // Campo ID auto-incremento
            $table->string('name'); // Nome do projeto (obrigatório)
            $table->text('description')->nullable(); // Descrição do projeto (opcional)
            $table->timestamps(); // created_at e updated_at automáticos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_pomodoro_projects');
    }
};
