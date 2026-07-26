@php
    $user = auth()->user();
@endphp

<div class="dash-sidebar-inner">

    <div class="dash-brand text-center">
        <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="dash-brand-logo">
        <h5 class="dash-brand-title">Jayadirana</h5>
        <p class="dash-brand-subtitle mb-0">Sistem Laporan Laba Rugi</p>
    </div>

    <div class="dash-menu-label">
        Menu Utama
    </div>

    <nav class="nav flex-column dash-nav">

        @if($user->role === 'admin')

            <a href="{{ url('/admin/dashboard') }}"
               class="dash-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

            <a href="{{ url('/admin/pendapatan') }}"
               class="dash-nav-link {{ request()->is('admin/pendapatan*') ? 'active' : '' }}">
                <i class="bi bi-wallet2 me-2"></i>
                Input Pendapatan
            </a>

            <a href="{{ url('/admin/pengeluaran') }}"
               class="dash-nav-link {{ request()->is('admin/pengeluaran*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack me-2"></i>
                Input Pengeluaran
            </a>

            <a href="{{ url('/admin/laporan') }}"
               class="dash-nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i>
                Laporan Laba Rugi
            </a>

            <a href="{{ url('/admin/riwayat-laporan') }}"
               class="dash-nav-link {{ request()->is('admin/riwayat-laporan*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i>
                Riwayat Laporan
            </a>

            <a href="{{ url('/admin/akun') }}"
               class="dash-nav-link {{ request()->is('admin/akun*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                Kelola Akun
            </a>

        @endif

        @if($user->role === 'direktur')

            <a href="{{ url('/direktur/dashboard') }}"
               class="dash-nav-link {{ request()->is('direktur/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

            <a href="{{ url('/direktur/laporan') }}"
               class="dash-nav-link {{ request()->is('direktur/laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i>
                Laporan Laba Rugi
            </a>

            <a href="{{ url('/direktur/riwayat-laporan') }}"
               class="dash-nav-link {{ request()->is('direktur/riwayat-laporan*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i>
                Riwayat Laporan
            </a>

            <a href="{{ url('/direktur/akun') }}"
               class="dash-nav-link {{ request()->is('direktur/akun*') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i>
                Kelola Akun
            </a>

        @endif
    </nav>
<div class="sidebar-logout">

    <form
        action="{{ route('logout') }}"
        method="POST"
        class="form-logout"
    >

        @csrf

        <button
            type="submit"
            class="dash-nav-link dash-logout-btn"
        >

            <i class="bi bi-box-arrow-right"></i>

            <span>Logout</span>

        </button>

    </form>

</div>