<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppBankManagerTransaction extends Model
{
    use HasFactory;

    protected $table = 'app_bank_manager_transactions';

    protected $fillable = ['operation_category_id', 'amount'];

    public function operationCategory()
    {
        return $this->belongsTo(AppBankManagerOperationCategory::class, 'operation_category_id');
    }
}
