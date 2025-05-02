<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\AppBankManagerOperationCategory;
use App\Models\AppBankManagerOperationType;
use App\Models\AppBankManagerTransaction;
use App\Models\AppBankManagerAccountBalance;

class BankManagerController extends Controller
{
    public function index(Request $request)
    {

        $operationTypes = AppBankManagerOperationType::all();
        $operationCategories = AppBankManagerOperationCategory::all();
        $types = AppBankManagerOperationType::with('categories')->get();

        $balance = AppBankManagerAccountBalance::firstOrCreate(['id' => 1], ['balance' => 0]);

        $transactions = AppBankManagerTransaction::with('operationCategory.operationType')->get();


        // Total de receitas
        $totalIncome = AppBankManagerTransaction::whereHas('operationCategory.operationType', function ($q) {
            $q->where('operation_type', 'income');
        })->sum('amount');

        // Agrupar despesas por categoria
        $expenseData = AppBankManagerTransaction::whereHas('operationCategory.operationType', function ($q) {
            $q->where('operation_type', 'expense');
        })
            ->with('operationCategory')
            ->get()
            ->groupBy('operationCategory.name')
            ->map(function ($group) {
                return $group->sum('amount');
            });

        // Para passar ao Blade
        $expenseLabels = $expenseData->keys();
        $expenseValues = $expenseData->values();


        $startDate = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
        $endDate = $request->input('end_date') ?? now()->endOfMonth()->toDateString();
    
        $expenses = AppBankManagerTransaction::whereHas('operationCategory.operationType', fn($q) =>
            $q->where('operation_type', 'expense'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('operationCategory')
            ->get();
    
        $incomeTotal = AppBankManagerTransaction::whereHas('operationCategory.operationType', fn($q) =>
            $q->where('operation_type', 'income'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');
    
        $groupedExpenses = $expenses->groupBy(fn($t) => $t->operationCategory->name ?? 'Sem Categoria');
    
        $labels = [];
        $values = [];
    
        foreach ($groupedExpenses as $category => $transactions) {
            $total = $transactions->sum('amount');
            $percentage = $incomeTotal > 0 ? ($total / $incomeTotal) * 100 : 0;
            $labels[] = $category;
            $values[] = round($percentage, 2);
        }

        return view('pages.bank-manager.index', compact('operationTypes', 'operationCategories', 'types', 'balance', 'transactions','totalIncome','expenseData','expenseLabels','expenseValues','labels', 'values', 'startDate', 'endDate',));
    }

    public function storeOperationCategory(Request $request)
    {
        $request->validate([
            'operation_type' => 'required|in:income,expense',
            'name' => 'required|string|max:255',
        ]);

        // Procura o tipo correto (income ou expense) na tabela de tipos
        $operationType = AppBankManagerOperationType::where('operation_type', $request->operation_type)->first();

        if (!$operationType) {
            return redirect()->back()->withErrors('Tipo de operação não encontrado.')->withInput();
        }

        // Agora cria a categoria
        AppBankManagerOperationCategory::create([
            'operation_type_id' => $operationType->id,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Categoria criada com sucesso!');
    }
    public function storeTransaction(Request $request)
    {
        // dd($request);

        $request->validate([
            'operation_category_id' => 'required|exists:app_bank_manager_operation_categories,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $category = AppBankManagerOperationCategory::with('operationType')->findOrFail($request->operation_category_id);

        $type = $category->operationType->operation_type; // 'income' ou 'expense'

        // Cria a transação
        AppBankManagerTransaction::create([
            'operation_category_id' => $request->operation_category_id,
            'amount' => $request->amount,
        ]);

        // Atualiza o saldo
        $balance = AppBankManagerAccountBalance::firstOrCreate(['id' => 1], ['balance' => 0]);

        if ($type === 'income') {
            $balance->balance += $request->amount;
        } elseif ($type === 'expense') {
            $balance->balance -= $request->amount;
        }

        $balance->save();

        return redirect()->back()->with('success', 'Transação registrada com sucesso!');
    }
}
