<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users      = User::where('role', 'user')->latest()->get();
        $totalUsers = $users->count();
        return view('admin.dashboard', compact('users', 'totalUsers'));
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);
        return view('admin.logs', compact('logs'));
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus akun admin!');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}