<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppBankManagerDebtInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_at',
    ];

    protected $dates = [
        'due_date',
        'paid_at',
    ];

    public function debt()
    {
        return $this->belongsTo(AppBankManagerDebt::class, 'debt_id');
    }

    public function isPaid()
    {
        return !is_null($this->paid_at);
    }
}
