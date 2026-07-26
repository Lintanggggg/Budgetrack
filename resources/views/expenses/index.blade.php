@extends('layouts.app')
@section('title', 'Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-arrow-up-circle me-2 text-danger"></i>Data Pengeluaran</h5>
        <a href="{{ route('expenses.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-lg me-1"></i>Tambah Pengeluaran
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
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $expense->expense_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $expense->category->name }}
                                </span>
                            </td>
                            <td class="text-danger fw-semibold">
                                Rp {{ number_format($expense->amount, 0, ',', '.') }}
                            </td>
                            <td>{{ $expense->note ?? '-' }}</td>
                            <td>
                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $expense->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $expense->id }}"
                                    action="{{ route('expenses.destroy', $expense->id) }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data pengeluaran
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
        title: 'Hapus Pengeluaran?',
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