<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppBankManagerFinancialGoal extends Model
{
    protected $fillable = [
        'name',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
    ];

}
