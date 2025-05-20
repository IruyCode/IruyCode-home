<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AppBankManagerDebt extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'total_amount',
        'installments',
        'start_date',
    ];

    // No model AppBankManagerDebt:
    public function installmentsList()
    {
        return $this->hasMany(AppBankManagerDebtInstallment::class, 'debt_id');
    }


    public function paidInstallments()
    {
        return $this->installments()->whereNotNull('paid_at');
    }

    public function remainingInstallments()
    {
        return $this->installments()->whereNull('paid_at');
    }

    

}
