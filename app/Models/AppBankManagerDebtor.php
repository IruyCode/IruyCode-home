<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppBankManagerDebtor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'due_date',
        'is_paid',
        'paid_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'is_paid' => 'boolean',
    ];

    public function edits()
    {
        return $this->hasMany(AppBankManagerDebtorEdit::class, 'debtor_id');
    }
}
