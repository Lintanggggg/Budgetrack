<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Http\Requests\StoreSavingsGoalRequest;
use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = SavingsGoal::where('user_id', auth()->id())->latest()->get();
        return view('savings-goals.index', compact('goals'));
    }

    public function create()
    {
        return view('savings-goals.create');
    }

    public function store(StoreSavingsGoalRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['current_amount'] = $validated['current_amount'] ?? 0;
        SavingsGoal::create($validated);
        return redirect()->route('savings-goals.index')
            ->with('success', 'Target tabungan berhasil ditambahkan!');
    }

    public function edit(SavingsGoal $savingsGoal)
    {
        abort_if($savingsGoal->user_id !== auth()->id(), 403);
        return view('savings-goals.edit', ['goal' => $savingsGoal]);
    }

    public function update(StoreSavingsGoalRequest $request, SavingsGoal $savingsGoal)
    {
        abort_if($savingsGoal->user_id !== auth()->id(), 403);
        $validated = $request->validated();
        $validated['current_amount'] = $validated['current_amount'] ?? 0;
        $savingsGoal->update($validated);
        return redirect()->route('savings-goals.index')
            ->with('success', 'Target tabungan berhasil diupdate!');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        abort_if($savingsGoal->user_id !== auth()->id(), 403);
        $savingsGoal->delete();
        return back()->with('success', 'Target tabungan berhasil dihapus!');
    }

    public function show(SavingsGoal $savingsGoal)
    {
        abort_if($savingsGoal->user_id !== auth()->id(), 403);
        return redirect()->route('savings-goals.index');
    }
    public function addFund(Request $request, SavingsGoal $savingsGoal)
{
    abort_if($savingsGoal->user_id !== auth()->id(), 403);

    $request->validate([
        'amount' => 'required|numeric|min:1|max:999999999',
    ], [
        'amount.min' => 'Nominal minimal Rp 1.',
    ]);

    $savingsGoal->current_amount += $request->amount;

    // Pastikan tidak melebihi target
    if ($savingsGoal->current_amount > $savingsGoal->target_amount) {
        $savingsGoal->current_amount = $savingsGoal->target_amount;
    }

    $savingsGoal->save();

    return back()->with('success', 'Dana berhasil ditambahkan!');
}
}