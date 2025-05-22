<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AppBankManagerDebtor;
use Illuminate\Support\Carbon;

class BankManagerDebtorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppBankManagerDebtor::create([
            'name' => 'João Silva',
            'description' => 'Empréstimo pessoal',
            'amount' => 500.00,
            'due_date' => Carbon::now()->addDays(15),
            'is_paid' => false,
        ]);

        AppBankManagerDebtor::create([
            'name' => 'Maria Oliveira',
            'description' => 'Pagamento por serviço prestado',
            'amount' => 1200.00,
            'due_date' => Carbon::now()->addDays(30),
            'is_paid' => false,
        ]);
    }
}
