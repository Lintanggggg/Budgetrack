@extends('layouts.app')
@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-shield-lock me-2 text-primary"></i>Ganti Password
                    </h5>

                    <form method="POST" action="{{ route('change-password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    placeholder="Password saat ini" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min. 8 karakter, huruf besar kecil, angka, simbol" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Minimal 8 karakter, huruf besar & kecil, angka, dan karakter unik (!@#$%).
                            </small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection