<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\SavingsGoal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalIncome  = Income::where('user_id', $userId)->sum('amount');
        $totalExpense = Expense::where('user_id', $userId)->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        $todayExpense   = Expense::where('user_id', $userId)
            ->whereDate('expense_date', today())
            ->sum('amount');
        $dailyLimit     = auth()->user()->daily_limit ?? 50000;
        $isOverspending = $todayExpense > $dailyLimit;

        $chartLabels = [];
        $chartData   = [];
        $startDate   = Carbon::now()->startOfMonth();
        $endDate     = Carbon::now();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $chartLabels[] = $date->format('d M');
            $chartData[]   = (float) Expense::where('user_id', $userId)
                ->whereDate('expense_date', $date->toDateString())
                ->sum('amount');
        }

        return view('dashboard.index', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'todayExpense',
            'dailyLimit',
            'isOverspending',
            'chartLabels',
            'chartData',
        ));
    }

    public function settings()
    {
        return view('settings.index');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'daily_limit' => 'required|numeric|min:1000|max:999999999',
        ], [
            'daily_limit.min' => 'Batas harian minimal Rp 1.000.',
        ]);

        auth()->user()->update([
            'daily_limit' => $request->daily_limit,
        ]);

        return back()->with('success', 'Batas harian berhasil diupdate!');
    }
    public function changePassword()
{
    return view('settings.change-password');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'password.min'                      => 'Password minimal 8 karakter.',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
    public function profile()
{
    return view('settings.profile');
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'photo' => [
            'nullable',
            'file',
            'image',
            'mimes:jpg,jpeg,png',
            'max:2048', // max 2MB
        ],
    ], [
        'photo.image' => 'File harus berupa gambar.',
        'photo.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
        'photo.max'   => 'Ukuran gambar maksimal 2MB.',
    ]);

    $data = ['name' => strip_tags($request->name)];

    if ($request->hasFile('photo')) {
        // Hapus foto lama
        if ($user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru dengan nama random
        $file     = $request->file('photo');
        $filename = \Illuminate\Support\Str::random(32) . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('photos', $filename, 'public');
        $data['photo'] = $path;
    }

    $user->update($data);

    // Log aktivitas
    \Illuminate\Support\Facades\Log::info('Profile updated', [
        'user_id' => $user->id,
        'email'   => $user->email,
        'ip'      => request()->ip(),
    ]);

    return back()->with('success', 'Profil berhasil diupdate!');
}
}