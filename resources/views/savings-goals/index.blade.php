@extends('layouts.app')
@section('title', 'Target Tabungan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-piggy-bank me-2 text-warning"></i>Target Tabungan</h5>
        <a href="{{ route('savings-goals.create') }}" class="btn btn-warning">
            <i class="bi bi-plus-lg me-1"></i>Tambah Target
        </a>
    </div>

    <div class="row g-3">
        @forelse($goals as $goal)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-bold mb-0">{{ $goal->goal_name }}</h6>
                        <span class="badge bg-warning text-dark">{{ $goal->progress_percentage }}%</span>
                    </div>

                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $goal->progress_percentage }}%"></div>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Terkumpul</small>
                            <strong class="text-success">
                                Rp {{ number_format($goal->current_amount, 0, ',', '.') }}
                            </strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Target</small>
                            <strong>Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    @if($goal->target_date)
                    <p class="text-muted small mb-3">
                        <i class="bi bi-calendar me-1"></i>
                        Target: {{ $goal->target_date->format('d M Y') }}
                    </p>
                    @endif
                    <div class="d-flex gap-2 mb-2">
                        <button class="btn btn-success btn-sm flex-fill"
                            onclick="tambahDana({{ $goal->id }}, '{{ $goal->goal_name }}')">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Dana
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('savings-goals.edit', $goal->id) }}"
                            class="btn btn-warning btn-sm flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <button class="btn btn-danger btn-sm flex-fill"
                            onclick="confirmDelete({{ $goal->id }})">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                        <form id="delete-form-{{ $goal->id }}"
                            action="{{ route('savings-goals.destroy', $goal->id) }}"
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>

                    {{-- Form tambah dana (hidden) --}}
                    <form id="fund-form-{{ $goal->id }}"
                        action="{{ route('savings-goals.add-fund', $goal->id) }}"
                        method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="amount" id="fund-amount-{{ $goal->id }}">
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-piggy-bank fs-1 d-block mb-3"></i>
                    Belum ada target tabungan. Yuk mulai menabung!
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
function tambahDana(id, nama) {
    Swal.fire({
        title: 'Tambah Dana',
        text: `Masukkan nominal dana untuk "${nama}"`,
        input: 'number',
        inputPlaceholder: 'Nominal (Rp)',
        inputAttributes: { min: 1 },
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Tambah',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value || value <= 0) return 'Nominal harus lebih dari 0!';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('fund-amount-' + id).value = result.value;
            document.getElementById('fund-form-' + id).submit();
        }
    });
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Target?',
        text: 'Target tabungan ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush