<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', Carbon::now()->format('Y-m'));
        $date          = Carbon::parse($selectedMonth);
        $userId        = auth()->id();

        $incomes = Income::where('user_id', $userId)
            ->whereYear('income_date', $date->year)
            ->whereMonth('income_date', $date->month)
            ->latest('income_date')
            ->get();

        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereYear('expense_date', $date->year)
            ->whereMonth('expense_date', $date->month)
            ->latest('expense_date')
            ->get();

        $totalIncome  = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        return view('reports.index', compact(
            'incomes',
            'expenses',
            'totalIncome',
            'totalExpense',
            'balance',
            'selectedMonth'
        ));
    }
}