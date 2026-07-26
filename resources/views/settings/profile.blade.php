@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-person-circle me-2 text-primary"></i>Profil Saya
                    </h5>

                    {{-- Foto Profil Saat Ini --}}
                    <div class="text-center mb-4">
                        @if(auth()->user()->photo)
                            <img src="{{ Storage::url(auth()->user()->photo) }}"
                                class="rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control"
                                value="{{ auth()->user()->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" name="photo"
                                class="form-control @error('photo') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Format: JPG, JPEG, PNG. Maksimal 2MB.
                            </small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i>Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection