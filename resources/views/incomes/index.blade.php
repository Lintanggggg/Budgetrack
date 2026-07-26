@extends('layouts.app')
@section('title', 'Pemasukan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-arrow-down-circle me-2 text-success"></i>Data Pemasukan</h5>
        <a href="{{ route('incomes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Pemasukan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Sumber</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomes as $income)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $income->income_date->format('d M Y') }}</td>
                            <td>{{ $income->source }}</td>
                            <td class="text-success fw-semibold">
                                Rp {{ number_format($income->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('incomes.edit', $income->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $income->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $income->id }}"
                                    action="{{ route('incomes.destroy', $income->id) }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data pemasukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Pemasukan?',
        text: 'Data ini akan dihapus permanen!',
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