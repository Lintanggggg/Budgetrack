@extends('layouts.app')
@section('title', 'Tambah Target Tabungan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-piggy-bank me-2 text-warning"></i>Tambah Target Tabungan
                    </h5>
                    <form method="POST" action="{{ route('savings-goals.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Target</label>
                            <input type="text" name="goal_name"
                                class="form-control @error('goal_name') is-invalid @enderror"
                                value="{{ old('goal_name') }}"
                                placeholder="Laptop baru, Dana darurat, dll" required>
                            @error('goal_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Dana (Rp)</label>
                            <input type="number" name="target_amount"
                                class="form-control @error('target_amount') is-invalid @enderror"
                                value="{{ old('target_amount') }}"
                                placeholder="0" min="0" required>
                            @error('target_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dana Saat Ini (Rp)</label>
                            <input type="number" name="current_amount"
                                class="form-control @error('current_amount') is-invalid @enderror"
                                value="{{ old('current_amount', 0) }}"
                                placeholder="0" min="0">
                            @error('current_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Target (opsional)</label>
                            <input type="date" name="target_date"
                                class="form-control @error('target_date') is-invalid @enderror"
                                value="{{ old('target_date') }}">
                            @error('target_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-fill">
                                <i class="bi bi-check-lg me-1"></i>Simpan
                            </button>
                            <a href="{{ route('savings-goals.index') }}" class="btn btn-secondary flex-fill">
                                <i class="bi bi-x-lg me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection