@extends('layouts.app')
@section('title', 'Batas Harian')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-gear me-2 text-primary"></i>Batas Pengaturan Keuangan Harian
                    </h5>
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Batas Pengeluaran Harian (Rp)</label>
                            <input type="number" name="daily_limit"
                                class="form-control @error('daily_limit') is-invalid @enderror"
                                value="{{ old('daily_limit', auth()->user()->daily_limit) }}"
                                min="1000" required>
                            <small class="text-muted">
                                Sistem akan memberi peringatan jika pengeluaran harian melebihi batas ini.
                            </small>
                            @error('daily_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection