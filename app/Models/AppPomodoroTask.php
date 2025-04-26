<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPomodoroTask extends Model
{
    use HasFactory;

    protected $table = 'app_pomodoro_tasks';

    protected $fillable = [
        'project_id',
        'task_name',
        'task_description',
    ];

    public function project()
    {
        return $this->belongsTo(AppPomodoroProject::class, 'project_id');
    }

    public function sessions()
    {
        return $this->hasMany(AppPomodoroSession::class, 'task_id');
    }
}
