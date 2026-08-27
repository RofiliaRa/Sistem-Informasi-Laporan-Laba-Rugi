@php
    $user = auth()->user();
@endphp

<div class="dash-sidebar-inner d-flex flex-column justify-content-between h-100 w-100">

    <div>
        {{-- BRAND --}}
        <div class="dash-brand text-center">
            <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="dash-brand-logo">
            <h5 class="dash-brand-title">Jayadirana</h5>
            <p class="dash-brand-subtitle mb-0">Sistem Laporan Laba Rugi</p>
        </div>

        {{-- MENU LABEL --}}
        <div class="dash-menu-label">
            Menu Utama
        </div>

        {{-- NAV --}}
        <nav class="nav flex-column dash-nav">
            @if($user && $user->role === 'admin')
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
                    Input Beban Usaha
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

                <a href="{{ url('/admin/backup-restore') }}"
                    class="dash-nav-link {{ request()->is('admin/backup-restore*') ? 'active' : '' }}">
                        <i class="bi bi-database me-2"></i>
                        Backup & Restore
                </a>
            @endif

            @if($user && $user->role === 'direktur')
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
    </div>

    {{-- LOGOUT --}}
    <div class="sidebar-logout mt-auto pt-3">
        <form
            action="{{ route('logout') }}"
            method="POST"
            class="form-logout m-0"
        >
            @csrf
            <button
                type="submit"
                class="dash-nav-link dash-logout-btn w-100 border-0 bg-transparent text-start"
            >
                <i class="bi bi-box-arrow-right me-2"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</div>