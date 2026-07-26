<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Http\Requests\StoreIncomeRequest;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', auth()->id())
            ->latest('income_date')->get();
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'income_date' => 'required|date|before_or_equal:today',
            'source'      => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1|max:999999999',
        ]);

        $validated['user_id'] = auth()->id();
        Income::create($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil ditambahkan!');
    }

    public function edit(Income $income)
    {
        abort_if($income->user_id !== auth()->id(), 403);
        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        abort_if($income->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'income_date' => 'required|date|before_or_equal:today',
            'source'      => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1|max:999999999',
        ]);

        $income->update($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil diupdate!');
    }

    public function destroy(Income $income)
    {
        abort_if($income->user_id !== auth()->id(), 403);
        $income->delete();
        return back()->with('success', 'Pemasukan berhasil dihapus!');
    }

    public function show(Income $income)
    {
        abort_if($income->user_id !== auth()->id(), 403);
        return redirect()->route('incomes.index');
    }
}