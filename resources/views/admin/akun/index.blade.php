@extends('layouts.dashboard')

@section('content')

{{-- HEADER UTAMA --}}
@php
    $actionBtn = auth()->user()->role == 'admin'
        ? '<button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle me-1"></i> Tambah Akun</button>'
        : null;
@endphp

@include('partials.page-header', [
    'title' => 'Kelola Akun',
    'subtitle' => 'Manajemen data pengguna dan hak akses sistem',
    'actionButton' => $actionBtn
])

{{-- DATA AKUN PANEL --}}
<div class="dash-panel-card-pro">
    {{-- HEADER CARD --}}
    @include('partials.panel-header', [
        'title' => 'Data Akun Pengguna',
        'icon' => 'bi bi-people-fill',
        'total' => $users->total(),
        'totalLabel' => 'Akun'
    ])

    {{-- BODY --}}
    <div class="dash-panel-body">
        <div class="table-responsive">
            <table class="akun-table text-nowrap">
                <thead class="akun-thead">
                    <tr>
                        <th width="70" class="text-center">No</th>
                        <th class="text-start">Nama Pengguna</th>
                        <th class="text-start">Email</th>
                        <th width="160" class="text-center">Role</th>
                        <th width="190" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        {{-- NO --}}
                        <td class="text-center">
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        {{-- NAMA --}}
                        <td class="text-start fw-semibold">
                            {{ $user->name }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="text-start text-break">
                            {{ $user->email }}
                        </td>

                        {{-- ROLE --}}
                        <td class="text-center">
                            @if($user->role == 'admin')
                                <span class="badge rounded-pill bg-success px-3 py-2 badge-fixed">
                                    Admin
                                </span>
                            @else
                                <span class="badge rounded-pill bg-primary px-3 py-2 badge-fixed">
                                    Direktur
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">
                            <div class="action-group justify-content-center">
                                <button
                                    class="btn btn-outline-primary btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $user->id }}"
                                >
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>

                                @if(auth()->user()->role == 'admin')
                                    <form
                                        action="{{ route('admin.akun.destroy', $user->id) }}"
                                        method="POST"
                                        class="form-hapus-akun d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger btn-action"
                                        >
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('partials.empty-table', [
                        'colspan' => 5,
                        'message' => 'Belum ada akun pengguna.'
                    ])
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4 d-flex justify-content-center justify-content-md-end">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- MODAL EDIT AKUN --}}
@foreach($users as $user)
    <div
        class="modal fade"
        id="modalEdit{{ $user->id }}"
        tabindex="-1"
        aria-labelledby="modalEditLabel{{ $user->id }}"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form
                    action="{{ route('admin.akun.update', $user->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="modalEditLabel{{ $user->id }}">
                            <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Akun
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pengguna</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ $user->name }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ $user->email }}"
                                required
                            >
                        </div>

                        @if(auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role" class="form-select">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="direktur" {{ $user->role == 'direktur' ? 'selected' : '' }}>
                                        Direktur
                                    </option>
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password_edit{{ $user->id }}"
                                    class="form-control"
                                    minlength="8"
                                    placeholder="Kosongkan jika tidak mengganti password"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary px-3"
                                    onclick="togglePassword('password_edit{{ $user->id }}')"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Minimal 8 karakter, mengandung huruf, angka dan simbol.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation_edit{{ $user->id }}"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary px-3"
                                    onclick="togglePassword('password_confirmation_edit{{ $user->id }}')"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button
                            type="button"
                            class="btn btn-secondary px-3 rounded-3"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary px-4 rounded-3"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- MODAL TAMBAH AKUN --}}
@if(auth()->user()->role == 'admin')
    <div
        class="modal fade"
        id="modalTambah"
        tabindex="-1"
        aria-labelledby="modalTambahLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form
                    action="{{ route('admin.akun.store') }}"
                    method="POST"
                    autocomplete="off"
                >
                    @csrf

                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="modalTambahLabel">
                            <i class="bi bi-person-plus me-2 text-primary"></i> Tambah Akun
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pengguna</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                autocomplete="off"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                autocomplete="new-email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password_tambah"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary px-3"
                                    onclick="togglePassword('password_tambah')"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Minimal 8 karakter, mengandung huruf, angka dan simbol.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation_tambah"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required
                                >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary px-3"
                                    onclick="togglePassword('password_confirmation_tambah')"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="direktur">Direktur</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button
                            type="button"
                            class="btn btn-secondary px-3 rounded-3"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary px-4 rounded-3"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-hapus-akun').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Iya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

function togglePassword(id) {
    let input = document.getElementById(id);
    if (input) {
        input.type = input.type === 'password' ? 'text' : 'password';
    }
}
</script>
@endpush

@endsection