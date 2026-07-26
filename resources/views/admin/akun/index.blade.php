@extends('layouts.dashboard')

@section('content')

<div class="dash-panel-card-pro mb-4">

    {{-- HEADER --}}
    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <div>

            <h3 class="mb-1 fw-bold">
                Kelola Akun
            </h3>
            
        </div>

        @if(auth()->user()->role == 'admin')

<button
    class="btn btn-primary px-4 py-2 rounded-3 shadow-sm"
    data-bs-toggle="modal"
    data-bs-target="#modalTambah"
>
    <i class="bi bi-plus-circle me-1"></i>
    Tambah Akun
</button>

@endif

    </div>

</div>

{{-- ===========================
     DATA AKUN
=========================== --}}

<div class="dash-panel-card-pro">

    {{-- HEADER CARD --}}
    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <h3>

            <i class="bi bi-people-fill me-2"></i>

            Data Akun Pengguna

        </h3>

        <span class="total-data-chip">

            Total {{ $users->total() }} Akun

        </span>

    </div>

    {{-- BODY --}}
    <div class="dash-panel-body">

        <div class="table-responsive">

            <table class="akun-table">

                <thead class="akun-thead">

                    <tr>

                        <th width="70">No</th>

                        <th>Nama Pengguna</th>

                        <th>Email</th>

                        <th width="160">Role</th>

                        <th width="190">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        {{-- NO --}}
                        <td>

                            {{ $users->firstItem() + $loop->index }}

                        </td>

                        {{-- NAMA --}}
                        <td>

                            {{ $user->name }}

                        </td>

                        {{-- EMAIL --}}
                        <td>

                            {{ $user->email }}

                        </td>

                        {{-- ROLE --}}
                        <td>

                            @if($user->role == 'admin')

                                <span class="badge rounded-pill bg-success px-4 py-2">

                                    Admin

                                </span>

                            @else

                                <span class="badge rounded-pill bg-primary px-4 py-2">

                                    Direktur

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
<td>

    <div class="d-flex justify-content-center align-items-center gap-2">

        <button
    class="btn btn-outline-primary btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#modalEdit{{ $user->id }}"
>
    <i class="bi bi-pencil-square me-1"></i>
    Edit
</button>

       @if(auth()->user()->role == 'admin')

<form
    action="{{ route('admin.akun.destroy',$user->id) }}"
    method="POST"
    class="form-hapus-akun"
>

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-outline-danger btn-sm"
    >
        <i class="bi bi-trash me-1"></i>
        Hapus
    </button>

</form>

@endif

    </div>

</td>
                    {{-- MODAL EDIT AKUN --}}

                    <div
                        class="modal fade"
                        id="modalEdit{{ $user->id }}"
                        tabindex="-1"
                    >

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <form
                                    action="{{ route('admin.akun.update',$user->id) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">

                                        <h5>
                                            Edit Akun
                                        </h5>

                                    </div>

<div class="modal-body">

    <div class="mb-2">

        <label>
            Nama Pengguna
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ $user->name }}"
            required
        >

    </div>

    <div class="mb-2">

        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ $user->email }}"
            required
        >

    </div>

   @if(auth()->user()->role == 'admin')

<div class="mb-2">

    <label>
        Role
    </label>

    <select
        name="role"
        class="form-select"
    >

        <option
            value="admin"
            {{ $user->role == 'admin' ? 'selected' : '' }}
        >
            Admin
        </option>

        <option
            value="direktur"
            {{ $user->role == 'direktur' ? 'selected' : '' }}
        >
            Direktur
        </option>

    </select>

</div>

@endif

 <div class="mb-2">

    <label>Password Baru</label>

    <div class="input-group">

        <input
            type="password"
            name="password"
            id="password_edit{{ $user->id }}"
            class="form-control"
            minlength="8"
            placeholder="Kosongkan jika tidak ingin mengganti password"
        >

        <button
            type="button"
            class="btn btn-outline-secondary"
            onclick="togglePassword('password_edit{{ $user->id }}')"
        >
            <i class="bi bi-eye"></i>
        </button>

    </div>

    <small class="text-muted small">
        Minimal 8 karakter, mengandung huruf, angka dan simbol.
    </small>

</div>

<div class="mb-2">

    <label>Konfirmasi Password Baru</label>

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
            class="btn btn-outline-secondary"
            onclick="togglePassword('password_confirmation_edit{{ $user->id }}')"
        >
            <i class="bi bi-eye"></i>
        </button>

    </div>

</div>
</div>
                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Batal
                                        </button>

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Simpan Perubahan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center"
                        >

                            Belum ada akun.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $users->links() }}

        </div>

    </div>

</div>

{{-- MODAL TAMBAH AKUN --}}

<div
@if(auth()->user()->role == 'admin')
    class="modal fade"
    id="modalTambah"
    tabindex="-1"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <form
    action="{{ route('admin.akun.store') }}"
    method="POST"
    autocomplete="off"
            >

                @csrf

                <div class="modal-header">

                    <h5>

                        Tambah Akun

                    </h5>

                </div>

                <div class="modal-body">

                    <div class="mb-2">

                        <label>
                            Nama Pengguna
                        </label>

                        <input
    type="text"
    name="name"
    class="form-control"
    autocomplete="off"
    required
>

                    </div>

                    <div class="mb-2">

                        <label>
                            Email
                        </label>

                        <input
    type="email"
    name="email"
    class="form-control"
    autocomplete="new-email"
    required
>

                    </div>

                    <div class="mb-2">

    <label>Password</label>

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
            class="btn btn-outline-secondary"
            onclick="togglePassword('password_tambah')"
        >
            <i class="bi bi-eye"></i>
        </button>

    </div>

    <small class="text-muted">
        Minimal 8 karakter, mengandung huruf, angka dan simbol.
    </small>

</div>

<div class="mb-2">

    <label>Konfirmasi Password</label>

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
            class="btn btn-outline-secondary"
            onclick="togglePassword('password_confirmation_tambah')"
        >
            <i class="bi bi-eye"></i>
        </button>

    </div>

</div>

                    <div class="mb-2">

                        <label>
                            Role
                        </label>

                        <select
                            name="role"
                            class="form-select"
                        >

                            <option value="admin">
                                Admin
                            </option>

                            <option value="direktur">
                                Direktur
                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
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

                confirmButtonText: 'Iya',
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

</script>

<script>

function togglePassword(id)
{
    let input = document.getElementById(id);

    if(input.type === 'password')
    {
        input.type = 'text';
    }
    else
    {
        input.type = 'password';
    }
}

</script>

@endpush

@endsection