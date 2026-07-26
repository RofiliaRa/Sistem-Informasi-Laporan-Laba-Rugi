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

            <div class="d-lg-none mb-3">

                <button
                    class="btn dash-menu-btn"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">

                    <i class="bi bi-list"></i>

                </button>

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
>

    <div class="offcanvas-body p-0">

        <aside class="dash-sidebar d-flex w-100">

            @include('partials.dashboard-sidebar')

        </aside>

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