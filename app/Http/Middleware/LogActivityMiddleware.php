<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            if (auth()->check()) {
                // Simpan ke database
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'email'   => auth()->user()->email,
                    'action'  => $this->getAction($request),
                    'method'  => $request->method(),
                    'url'     => $request->fullUrl(),
                    'ip'      => $request->ip(),
                ]);

                // Tetap simpan ke file log
                Log::channel('activity')->info($this->getAction($request), [
                    'user_id' => auth()->id(),
                    'email'   => auth()->user()->email,
                    'method'  => $request->method(),
                    'url'     => $request->fullUrl(),
                    'ip'      => $request->ip(),
                ]);
            }
        }

        return $response;
    }

    private function getAction(Request $request): string
    {
        $method = $request->method();
        $path   = $request->path();

        if (str_contains($path, 'login'))          return 'User Login';
        if (str_contains($path, 'logout'))         return 'User Logout';
        if (str_contains($path, 'incomes')) {
            if ($method === 'POST')                return 'Tambah Pemasukan';
            if (in_array($method, ['PUT', 'PATCH'])) return 'Edit Pemasukan';
            if ($method === 'DELETE')              return 'Hapus Pemasukan';
        }
        if (str_contains($path, 'expenses')) {
            if ($method === 'POST')                return 'Tambah Pengeluaran';
            if (in_array($method, ['PUT', 'PATCH'])) return 'Edit Pengeluaran';
            if ($method === 'DELETE')              return 'Hapus Pengeluaran';
        }
        if (str_contains($path, 'categories')) {
            if ($method === 'POST')                return 'Tambah Kategori';
            if (in_array($method, ['PUT', 'PATCH'])) return 'Edit Kategori';
            if ($method === 'DELETE')              return 'Hapus Kategori';
        }
        if (str_contains($path, 'savings-goals')) {
            if ($method === 'POST')                return 'Tambah Target Tabungan';
            if (in_array($method, ['PUT', 'PATCH'])) return 'Edit Target Tabungan';
            if ($method === 'DELETE')              return 'Hapus Target Tabungan';
        }
        if (str_contains($path, 'profile'))        return 'Update Profil';
        if (str_contains($path, 'settings'))       return 'Update Pengaturan';
        if (str_contains($path, 'change-password')) return 'Ganti Password';
        if (str_contains($path, 'add-fund'))       return 'Tambah Dana Tabungan';

        return strtoupper($method) . ' ' . $path;
    }
}