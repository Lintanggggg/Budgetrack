@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <i class="bi bi-people me-2 text-danger"></i>Daftar User Terdaftar
                    </h5>
                    <p class="text-muted">Total {{ $users->count() }} user terdaftar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <i class="bi bi-person-circle me-2 text-muted"></i>
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('admin.users.destroy', $user->id) }}"
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
                                Belum ada user terdaftar
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
function confirmDelete(userId, userName) {
    Swal.fire({
        title: 'Hapus User?',
        text: `Akun "${userName}" akan dihapus permanen beserta semua datanya!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + userId).submit();
        }
    });
}
</script>
@endpush