@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Laporan Keuangan Bulanan
        </h5>
    </div>

    {{-- Filter Bulan --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Pilih Bulan</label>
                    <input type="month" name="month" class="form-control"
                        value="{{ $selectedMonth }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <p class="mb-1 opacity-75">Total Pemasukan</p>
                    <h4 class="fw-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <p class="mb-1 opacity-75">Total Pengeluaran</p>
                    <h4 class="fw-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #1a237e, #283593)">
                <div class="card-body text-center">
                    <p class="mb-1 opacity-75">Saldo Akhir</p>
                    <h4 class="fw-bold">Rp {{ number_format($balance, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Tabel Pemasukan --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-arrow-down-circle me-2 text-success"></i>Riwayat Pemasukan
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Sumber</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomes as $income)
                                <tr>
                                    <td>{{ $income->income_date->format('d M') }}</td>
                                    <td>{{ $income->source }}</td>
                                    <td class="text-success">
                                        Rp {{ number_format($income->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Tidak ada pemasukan bulan ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Pengeluaran --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-arrow-up-circle me-2 text-danger"></i>Riwayat Pengeluaran
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('d M') }}</td>
                                    <td>{{ $expense->category->name }}</td>
                                    <td class="text-danger">
                                        Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Tidak ada pengeluaran bulan ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection