<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppBankManagerOperationType extends Model
{
    use HasFactory;

    protected $table = 'app_bank_manager_operation_types';

    protected $fillable = [
        'operation_type',
        'description',
    ];

    // Relacionamento: Um tipo de operação pode ter várias categorias
    public function categories()
    {
        return $this->hasMany(AppBankManagerOperationCategory::class, 'operation_type_id');
    }

  
}
