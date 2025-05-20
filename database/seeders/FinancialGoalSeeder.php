<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_bank_manager_financial_goals')->insert([
            [
                'name' => 'Férias em Portugal',
                'description' => 'Meta para viagem de férias em setembro',
                'target_amount' => 2000.00,
                'current_amount' => 500.00,
                'deadline' => Carbon::parse('2025-09-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reserva de Emergência',
                'description' => 'Fundo de emergência para 6 meses de despesas',
                'target_amount' => 10000.00,
                'current_amount' => 2750.00,
                'deadline' => Carbon::parse('2026-01-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compra de Equipamento 3D',
                'description' => 'Comprar impressora 3D e acessórios profissionais',
                'target_amount' => 1500.00,
                'current_amount' => 1200.00,
                'deadline' => Carbon::parse('2025-07-15'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
