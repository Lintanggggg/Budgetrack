@extends('layouts.app')
@section('title', 'Edit Pemasukan')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-pencil-circle me-2 text-warning"></i>Edit Pemasukan
                    </h5>
                    <form method="POST" action="{{ route('incomes.update', $income->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="income_date"
                                class="form-control @error('income_date') is-invalid @enderror"
                                value="{{ old('income_date', $income->income_date->format('Y-m-d')) }}" required>
                            @error('income_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sumber Pemasukan</label>
                            <select name="source" class="form-select @error('source') is-invalid @enderror" required>
                                <option value="">-- Pilih Sumber --</option>
                                <option value="Kiriman Orang Tua" {{ old('source', $income->source) == 'Kiriman Orang Tua' ? 'selected' : '' }}>Kiriman Orang Tua</option>
                                <option value="Beasiswa" {{ old('source', $income->source) == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                                <option value="Freelance" {{ old('source', $income->source) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="Kerja Part-time" {{ old('source', $income->source) == 'Kerja Part-time' ? 'selected' : '' }}>Kerja Part-time</option>
                                <option value="Lainnya" {{ old('source', $income->source) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nominal (Rp)</label>
                            <input type="number" name="amount"
                                class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount', $income->amount) }}"
                                placeholder="0" min="0" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-fill">
                                <i class="bi bi-check-lg me-1"></i>Update
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