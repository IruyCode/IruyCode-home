<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BankManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Inserir os tipos de operação
        $incomeId = DB::table('app_bank_manager_operation_types')->insertGetId([
            'operation_type' => 'income',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $expenseId = DB::table('app_bank_manager_operation_types')->insertGetId([
            'operation_type' => 'expense',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Inserir categorias vinculadas aos tipos
        DB::table('app_bank_manager_operation_categories')->insert([
            [
                'name' => 'Salário',
                'operation_type_id' => $incomeId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Renda extra',
                'operation_type_id' => $expenseId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
