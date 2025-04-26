<?php

namespace App\Http\Controllers;

use App\Models\AppPomodoroProject;
use App\Models\AppPomodoroSession;
use App\Models\AppPomodoroTask;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PomoTimerController extends Controller
{
    public function index()
    {
        $projects = AppPomodoroProject::all(); // Pegar todos projetos

        $tasks = AppPomodoroTask::with('sessions')->get();
        return view('pages.pomo-timer.index',compact('projects','tasks'));
        

    }

    // Formulário para criar projetos
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        AppPomodoroProject::create([
            'name' => $request->nome,
            'description' => $request->descricao,
        ]);

        return redirect()->back()->with('success', 'Projeto criado com sucesso!');
    }

       // Salvar nova tarefa
       public function storeTask(Request $request)
       {
           $request->validate([
               'project_id' => 'required|exists:app_pomodoro_projects,id',
               'task_name' => 'required|string|max:255',
               'task_description' => 'nullable|string',
           ]);
   
           AppPomodoroTask::create([
               'project_id' => $request->project_id,
               'task_name' => $request->task_name,
               'task_description' => $request->task_description,
           ]);
   
           return redirect()->back()->with('success', 'Tarefa criada com sucesso!');
       }

       public function storeSession(Request $request)
{
    $request->validate([
        'task_id' => 'required|exists:app_pomodoro_tasks,id',
    ]);

    AppPomodoroSession::create([
        'task_id' => $request->task_id,
        'completed_at' => Carbon::now(),
    ]);

    return response()->json(['message' => 'Pomodoro registrado com sucesso!']);
}
}
