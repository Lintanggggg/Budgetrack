<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // Log ke database
        ActivityLog::create([
            'user_id' => $user->id,
            'email'   => $user->email,
            'action'  => 'User Login',
            'method'  => 'POST',
            'url'     => $request->fullUrl(),
            'ip'      => $request->ip(),
        ]);

        // Log ke file
        Log::channel('activity')->info('User Login', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $request->ip(),
        ]);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (auth()->check()) {
            // Log ke database
            ActivityLog::create([
                'user_id' => auth()->id(),
                'email'   => auth()->user()->email,
                'action'  => 'User Logout',
                'method'  => 'POST',
                'url'     => $request->fullUrl(),
                'ip'      => $request->ip(),
            ]);

            // Log ke file
            Log::channel('activity')->info('User Logout', [
                'user_id' => auth()->id(),
                'email'   => auth()->user()->email,
                'ip'      => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}