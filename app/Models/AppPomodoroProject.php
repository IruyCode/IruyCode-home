<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPomodoroProject extends Model
{
    use HasFactory;

    protected $table = 'app_pomodoro_projects';

    protected $fillable = [
        'name',
        'description',
    ];

    public function tasks()
    {
        return $this->hasMany(AppPomodoroTask::class, 'project_id');
    }
}
