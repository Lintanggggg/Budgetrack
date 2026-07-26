@extends('layouts.app')
@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-plus-circle me-2 text-danger"></i>Tambah Pengeluaran
                    </h5>
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="expense_date"
                                class="form-control @error('expense_date') is-invalid @enderror"
                                value="{{ old('expense_date', date('Y-m-d')) }}" required>
                            @error('expense_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal (Rp)</label>
                            <input type="number" name="amount"
                                class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount') }}"
                                placeholder="0" min="0" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Catatan (opsional)</label>
                            <textarea name="note" rows="3"
                                class="form-control @error('note') is-invalid @enderror"
                                placeholder="Catatan tambahan...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger flex-fill">
                                <i class="bi bi-check-lg me-1"></i>Simpan
                            </button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary flex-fill">
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