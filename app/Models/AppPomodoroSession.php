<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPomodoroSession extends Model
{
    use HasFactory;

    protected $table = 'app_pomodoro_sessions';

    protected $fillable = [
        'task_id',
        'completed_at',
    ];

    protected $dates = [
        'completed_at',
    ];

    public function task()
    {
        return $this->belongsTo(AppPomodoroTask::class, 'task_id');
    }
}
