<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppBankManagerDebtorEdit extends Model
{
    use HasFactory;

    protected $fillable = [
        'debtor_id',
        'old_amount',
        'new_amount',
        'old_due_date',
        'new_due_date',
        'reason'
    ];

    protected $casts = [
        'old_due_date' => 'date',
        'new_due_date' => 'date',
    ];

    public function debtor()
    {
        return $this->belongsTo(AppBankManagerDebtor::class, 'debtor_id');
    }
}
