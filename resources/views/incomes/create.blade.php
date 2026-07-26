@extends('layouts.app')
@section('title', 'Tambah Pemasukan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-plus-circle me-2 text-success"></i>Tambah Pemasukan
                    </h5>
                    <form method="POST" action="{{ route('incomes.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="income_date"
                                class="form-control @error('income_date') is-invalid @enderror"
                                value="{{ old('income_date', date('Y-m-d')) }}" required>
                            @error('income_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sumber Pemasukan</label>
                            <select name="source" class="form-select @error('source') is-invalid @enderror" required>
                                <option value="">-- Pilih Sumber --</option>
                                <option value="Kiriman Orang Tua" {{ old('source') == 'Kiriman Orang Tua' ? 'selected' : '' }}>Kiriman Orang Tua</option>
                                <option value="Beasiswa" {{ old('source') == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                                <option value="Freelance" {{ old('source') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="Kerja Part-time" {{ old('source') == 'Kerja Part-time' ? 'selected' : '' }}>Kerja Part-time</option>
                                <option value="Lainnya" {{ old('source') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nominal (Rp)</label>
                            <input type="number" name="amount"
                                class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount') }}"
                                placeholder="0" min="0" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-check-lg me-1"></i>Simpan
                            </button>
                            <a href="{{ route('incomes.index') }}" class="btn btn-secondary flex-fill">
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