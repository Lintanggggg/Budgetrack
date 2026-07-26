@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75">Total Pemasukan</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                        </div>
                        <i class="bi bi-arrow-down-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75">Total Pengeluaran</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                        </div>
                        <i class="bi bi-arrow-up-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-white" style="background: linear-gradient(135deg, #1a237e, #283593)">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75">Saldo Saat Ini</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($balance, 0, ',', '.') }}</h4>
                        </div>
                        <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Peringatan Boros --}}
    @if($isOverspending)
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
        <div>
            <strong>Peringatan Boros!</strong> Pengeluaran kamu hari ini
            <strong>Rp {{ number_format($todayExpense, 0, ',', '.') }}</strong>
            melebihi batas harian yang kamu tetapkan
            <strong>Rp {{ number_format($dailyLimit, 0, ',', '.') }}</strong>.
            Pertimbangkan untuk mengurangi pengeluaran!
        </div>
    </div>
    @endif
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-bar-chart me-2 text-primary"></i>Pengeluaran Bulan Ini (Per Hari)
                </h6>
                <canvas id="expenseChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('expenseChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pengeluaran (Rp)',
            data: {!! json_encode($chartData) !!},
            backgroundColor: 'rgba(26, 35, 126, 0.7)',
            borderColor: 'rgba(26, 35, 126, 1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: {
                callback: value => 'Rp ' + value.toLocaleString('id-ID')
            }}
        }
    }
});
</script>
@endpush