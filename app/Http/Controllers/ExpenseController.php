<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')
            ->where('user_id', auth()->id())
            ->latest('expense_date')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        Expense::create($validated);
        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        $categories = Category::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        $expense->update($request->validated());
        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        $expense->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus!');
    }

    public function show(Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        return redirect()->route('expenses.index');
    }
}