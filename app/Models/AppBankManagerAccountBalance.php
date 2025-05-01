<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppBankManagerAccountBalance extends Model
{
    use HasFactory;

    protected $table = 'app_bank_manager_account_balances';

    protected $fillable = [
        'balance',
    ];
}
