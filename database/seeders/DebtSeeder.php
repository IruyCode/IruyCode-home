<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AppBankManagerDebt;
use App\Models\AppBankManagerDebtInstallment;
use Carbon\Carbon;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemplo de dívida
        $debt = AppBankManagerDebt::create([
            'name' => 'Cartão de Crédito',
            'description' => 'Compra de eletrodoméstico parcelada',
            'total_amount' => 1200.00,
            'installments' => 6,
            'start_date' => Carbon::now()->startOfMonth(), // início deste mês
        ]);

        // Geração automática das parcelas
        $installmentAmount = round($debt->total_amount / $debt->installments, 2);

        for ($i = 0; $i < $debt->installments; $i++) {
            AppBankManagerDebtInstallment::create([
                'debt_id' => $debt->id,
                'installment_number' => $i + 1,
                'amount' => $installmentAmount,
                'due_date' => $debt->start_date->copy()->addMonths($i),
                'paid_at' => null, // Deixe como null inicialmente
            ]);
        }
    }
}
