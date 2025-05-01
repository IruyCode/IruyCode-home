<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppBankManagerOperationCategory extends Model
{
    use HasFactory;

    protected $table = 'app_bank_manager_operation_categories';

    protected $fillable = ['operation_type_id', 'name'];

    public function operationType()
    {
        return $this->belongsTo(AppBankManagerOperationType::class, 'operation_type_id');
    }

    public function transactions()
    {
        return $this->hasMany(AppBankManagerTransaction::class, 'operation_category_id');
    }
}
