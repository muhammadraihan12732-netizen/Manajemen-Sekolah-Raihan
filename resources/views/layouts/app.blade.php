<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div class="app">
    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="sidebar">
        <div class="brand"><i class="bi bi-mortarboard-fill"></i> Raihan Education</div>
        <nav>
            <a href="{{ route('dashboard') }}" class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i> Dashboard
            </a>
            <a href="{{ route('students.index') }}" class="nav-link-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard-fill"></i> Data Siswa
            </a>
            <a href="{{ route('classes.index') }}" class="nav-link-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i> Data Kelas
            </a>
            <a href="{{ route('majors.index') }}" class="nav-link-item {{ request()->routeIs('majors.*') ? 'active' : '' }}">
                <i class="bi bi-book-half"></i> Data Jurusan
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
            </a>
            <a href="{{ route('settings.index') }}" class="nav-link-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i> Pengaturan
            </a>
            <div class="nav-sep"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </nav>
    </aside>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    {{-- ===== MAIN ===== --}}
    <div class="main">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" type="button" aria-label="Menu"><i class="bi bi-list"></i></button>

            <form class="search" action="{{ route('students.index') }}" method="GET">
                <i class="bi bi-search"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari siswa (nama / NIS / NISN)...">
            </form>

            <div class="user">
                <span class="icon-btn"><i class="bi bi-envelope-fill"></i><span class="dot bg-info">3</span></span>
                <span class="icon-btn"><i class="bi bi-bell-fill"></i><span class="dot bg-danger">5</span></span>
                <a href="{{ route('settings.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-reset">
                    <img class="avatar" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0b2a85&color=fff" alt="Avatar">
                    <div class="user-name">{{ auth()->user()->name }}<small>Admin</small></div>
                </a>
            </div>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" data-autohide role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
