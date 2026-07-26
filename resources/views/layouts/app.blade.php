<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BudgetRack - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
        .sidebar .nav-link i { margin-right: 10px; }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-top {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 20px;
            margin-left: 250px;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .brand-logo {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="brand-logo">
        <h5 class="text-white mb-0 fw-bold">
            <i class="bi bi-wallet2 me-2"></i>BudgetRack
        </h5>
        <small class="text-white-50">Manajemen Keuangan</small>
    </div>
    <nav class="nav flex-column mt-2">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('incomes.index') }}"
           class="nav-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-circle"></i> Pemasukan
        </a>
        <a href="{{ route('expenses.index') }}"
           class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-up-circle"></i> Pengeluaran
        </a>
        <a href="{{ route('savings-goals.index') }}"
           class="nav-link {{ request()->routeIs('savings-goals.*') ? 'active' : '' }}">
            <i class="bi bi-piggy-bank"></i> Target Tabungan
        </a>
        <a href="{{ route('reports.index') }}"
           class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
        </a>
        <a href="{{ route('settings') }}"
           class="nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Batas Harian
        </a>
    </nav>
</div>

{{-- Top Navbar --}}
<div class="navbar-top d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold text-muted">@yield('title')</h6>
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
    @if(auth()->user()->photo)
        <img src="{{ Storage::url(auth()->user()->photo) }}"
            class="rounded-circle"
            style="width: 32px; height: 32px; object-fit: cover;">
    @else
        <i class="bi bi-person-circle fs-5"></i>
    @endif
    {{ auth()->user()->name }}
</button>
        <ul class="dropdown-menu dropdown-menu-end">
                <li>
        <a href="{{ route('profile') }}" class="dropdown-item">
            <i class="bi bi-person-circle me-2"></i>Profil Saya
        </a>
        </li>
        <a href="{{ route('change-password') }}" class="dropdown-item">
            <i class="bi bi-shield-lock me-2"></i>Ganti Password
        </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

{{-- Main Content --}}
<div class="main-content mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>