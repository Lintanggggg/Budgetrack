@extends('layouts.admin')
@section('title', 'Activity Log')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <i class="bi bi-journal-text me-2 text-danger"></i>Activity Log
                    </h5>
                    <p class="text-muted mb-0">Riwayat aktivitas semua pengguna</p>
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
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Method</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                            <td>
                                <small>{{ $log->created_at->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $log->email }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeColor = 'secondary';
                                    if (str_contains($log->action, 'Login'))   $badgeColor = 'success';
                                    if (str_contains($log->action, 'Logout'))  $badgeColor = 'warning';
                                    if (str_contains($log->action, 'Hapus'))   $badgeColor = 'danger';
                                    if (str_contains($log->action, 'Tambah'))  $badgeColor = 'primary';
                                    if (str_contains($log->action, 'Edit'))    $badgeColor = 'info';
                                    if (str_contains($log->action, 'Update'))  $badgeColor = 'info';
                                    if (str_contains($log->action, 'Ganti'))   $badgeColor = 'dark';
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">{{ $log->action }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $log->method }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $log->ip }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-journal-x fs-3 d-block mb-2"></i>
                                Belum ada aktivitas tercatat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $logs->links('pagination::bootstrap-5') }}
        </div>
        </div>
    </div>
</div>
@endsection