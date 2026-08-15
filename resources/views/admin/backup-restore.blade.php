@extends('layouts.dashboard')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-database me-2"></i>
                Backup & Restore Database
            </h3>

            <small class="text-muted">
                Kelola pencadangan dan pemulihan database sistem laporan laba rugi.
            </small>
        </div>
    </div>
</div>


{{-- BACKUP & RESTORE --}}
<div class="row g-4">

    {{-- BACKUP DATABASE --}}
    <div class="col-12 col-lg-6">
        <div class="dash-panel-card-pro h-100">

            <div class="dash-panel-header">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-cloud-arrow-down me-2 text-primary"></i>
                        Backup Database
                    </h5>

                    <small class="text-muted">
                        Buat salinan database untuk menjaga keamanan data.
                    </small>
                </div>
            </div>

            <div class="dash-panel-body">

                <div class="text-center py-3">

                    <div class="mb-3">
                        <i
                            class="bi bi-database-check text-primary"
                            style="font-size: 55px;"
                        ></i>
                    </div>

                    <h6 class="fw-bold mb-2">
                        Cadangkan Database
                    </h6>

                    <p class="text-muted mb-4">
                        Sistem akan membuat file backup database dalam format
                        <strong>.sql</strong> yang dapat digunakan untuk pemulihan
                        data apabila diperlukan.
                    </p>

                    <a
                        href="{{ route('admin.backup') }}"
                        class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 px-4 py-2 rounded-3 fw-bold"
                    >
                        <i class="bi bi-download"></i>
                        <span>Backup Database</span>
                    </a>

                </div>

            </div>
        </div>
    </div>


    {{-- RESTORE DATABASE --}}
    <div class="col-12 col-lg-6">
        <div class="dash-panel-card-pro h-100">

            <div class="dash-panel-header">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-cloud-arrow-up me-2 text-warning"></i>
                        Restore Database
                    </h5>

                    <small class="text-muted">
                        Pulihkan database menggunakan file backup sebelumnya.
                    </small>
                </div>
            </div>

            <div class="dash-panel-body">

                <form
                    action="{{ route('admin.restore') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="formRestore"
                >

                    @csrf

                    <div class="mb-3">
                        <label
                            for="backup_file"
                            class="form-label fw-semibold"
                        >
                            Pilih File Backup
                        </label>

                        <input
                            type="file"
                            name="backup_file"
                            id="backup_file"
                            class="form-control"
                            accept=".sql"
                            required
                        >

                        <small class="text-muted">
                            Hanya file database dengan format
                            <strong>.sql</strong> yang dapat digunakan.
                        </small>
                    </div>

                    <div class="alert alert-warning border-0 rounded-3 mb-4">
                        <div class="d-flex gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>

                            <div>
                                <strong>Perhatian</strong>
                                <div class="small mt-1">
                                    Proses restore akan mengganti data database
                                    dengan data dari file backup yang dipilih.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">

                        <button
                            type="submit"
                            class="btn btn-warning d-inline-flex align-items-center justify-content-center gap-2 px-4 py-2 rounded-3 fw-bold"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Restore Database</span>
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

</div>


{{-- INFORMASI --}}
<div class="dash-panel-card-pro mt-4">

    <div class="dash-panel-body">

        <div class="d-flex gap-3 align-items-start">

            <div class="text-primary">
                <i class="bi bi-info-circle-fill fs-4"></i>
            </div>

            <div>
                <h6 class="fw-bold mb-2">
                    Informasi Backup & Restore
                </h6>

                <ul class="text-muted mb-0 ps-3">
                    <li>
                        Backup digunakan untuk membuat salinan database sistem.
                    </li>

                    <li>
                        File backup disimpan dalam format
                        <strong>.sql</strong>.
                    </li>

                    <li>
                        Restore digunakan untuk memulihkan database dari file
                        backup yang telah dibuat sebelumnya.
                    </li>

                    <li>
                        Pastikan file backup yang digunakan merupakan file yang
                        benar sebelum melakukan restore.
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>


{{-- KONFIRMASI RESTORE --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const formRestore = document.getElementById('formRestore');

    if (formRestore) {

        formRestore.addEventListener('submit', function (e) {

            e.preventDefault();

            const fileInput = document.getElementById('backup_file');

            if (!fileInput.files.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File belum dipilih',
                    text: 'Silakan pilih file backup terlebih dahulu.',
                    confirmButtonColor: '#f59e0b'
                });

                return;
            }

            Swal.fire({
                title: 'Restore Database?',
                text: 'Data database akan dipulihkan menggunakan file backup yang dipilih. Pastikan file yang digunakan sudah benar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Restore',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {
                    formRestore.submit();
                }

            });

        });

    }

});
</script>
@endpush

@endsection