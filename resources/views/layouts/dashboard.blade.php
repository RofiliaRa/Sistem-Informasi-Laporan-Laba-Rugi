<!doctype html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>

        {{ $title ?? 'Dashboard Sistem Laporan Laba Rugi' }}

    </title>

    <link
        rel="icon"
        type="image/jpeg"
        href="{{ asset('images/logo fc.jpeg') }}"
    >

    <link
        rel="shortcut icon"
        href="{{ asset('images/logo fc.jpeg') }}"
    >

    {{-- BOOTSTRAP --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- BOOTSTRAP ICONS --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    {{-- CUSTOM CSS --}}

    <link
        href="{{ asset('css/custom.css') }}"
        rel="stylesheet"
    >

</head>

<body>

<div class="dashboard-shell">

    <aside class="dash-sidebar d-none d-lg-flex">

        @include('partials.dashboard-sidebar')

    </aside>

    <div class="dash-main">

        <main class="dash-content">
            @php
                $routeName = request()->route() ? request()->route()->getName() : '';
                $pageTitle = 'Dashboard';

                if (str_contains($routeName, 'dashboard')) {
                    $pageTitle = 'Dashboard';
                } elseif (str_contains($routeName, 'akun')) {
                    $pageTitle = 'Kelola Akun';
                } elseif (str_contains($routeName, 'pendapatan')) {
                    $pageTitle = 'Data Pendapatan';
                } elseif (str_contains($routeName, 'pengeluaran')) {
                    $pageTitle = 'Data Pengeluaran';
                } elseif (str_contains($routeName, 'laporan') && !str_contains($routeName, 'riwayat')) {
                    $pageTitle = 'Laporan Laba Rugi';
                } elseif (str_contains($routeName, 'riwayat')) {
                    $pageTitle = 'Riwayat Laporan';
                }
            @endphp

            {{-- MOBILE STICKY TOP NAVBAR HEADER --}}
            <div class="dash-mobile-navbar d-lg-none mb-3">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center gap-2">
                        <button
                            class="btn dash-menu-btn"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#mobileSidebar"
                            aria-label="Navigasi Menu"
                        >
                            <i class="bi bi-list fs-4"></i>
                        </button>

                        <h5 class="dash-mobile-page-title mb-0">
                            {{ $pageTitle }}
                        </h5>
                    </div>

                    @auth
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->role == 'admin' ? 'Ketua Unit' : 'Direktur' }}
                            </span>
                        </div>
                    @endauth
                </div>
            </div>

            @yield('content')
        </main>

    </div>

</div>

</div>

{{-- SIDEBAR MOBILE --}}

<div
    class="offcanvas offcanvas-start dash-offcanvas"
    tabindex="-1"
    id="mobileSidebar"
    aria-labelledby="mobileSidebarLabel"
>

    <div class="offcanvas-body p-0">

        <div class="dash-sidebar-mobile-container h-100">

            @include('partials.dashboard-sidebar')

        </div>

    </div>

</div>

{{-- BOOTSTRAP JS --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- CHART JS --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- SWEETALERT --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SUCCESS ALERT --}}

@if(session('success'))

<script>

    Swal.fire({

        icon: 'success',

        title: 'Berhasil',

        text: '{{ session('success') }}',

        confirmButtonColor: '#2563eb',

        confirmButtonText: 'OK'

    });

</script>

@endif

{{-- ERROR ALERT --}}

@if(session('error'))

<script>

    Swal.fire({

        icon: 'error',

        title: 'Akses Ditolak',

        text: '{{ session('error') }}',

        confirmButtonColor: '#dc3545',

        confirmButtonText: 'OK'

    });

</script>

@endif

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-logout').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({

                title: 'Keluar dari Sistem?',
                text: 'Anda akan keluar dari akun saat ini.',
                icon: 'question',

                showCancelButton: true,

                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',

                confirmButtonText: 'Ya, Keluar',
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

@stack('scripts')

</body>
</html>