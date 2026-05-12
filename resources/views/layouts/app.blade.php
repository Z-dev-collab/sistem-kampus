<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0b1120">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Jurnal Digital</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="app-container">
    {{-- Top Header --}}
    <header class="top-header">
        <div class="header-title">
            <h1>@yield('title', 'Dashboard')</h1>
            <p>@yield('subtitle', now()->translatedFormat('l, d F Y'))</p>
        </div>
        <div class="header-action" style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('profile.edit') }}">
                <img src="{{ auth()->user()->photo_url }}" class="user-avatar" alt="Profile">
            </a>
            <a href="{{ route('logout') }}" style="color:white; opacity:0.9; padding:4px;" title="Logout">
                <i data-lucide="log-out"></i>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success"><i data-lucide="check-circle"></i> <span>{{ session('success') }}</span></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i data-lucide="alert-circle"></i> <span>{{ session('error') }}</span></div>
        @endif
        
        @yield('content')

        {{-- Logo/Watermark at the bottom of the page --}}
        <div style="text-align: center; margin-top: 40px; padding-bottom: 20px; opacity: 0.5; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 18px; font-weight: 700; color: var(--text-muted);">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 20px; height: 20px; object-fit: contain;">
                JURNAL DIGITAL
            </div>
            <div style="font-size: 11px; margin-top: 4px; letter-spacing: 1px; color: var(--text-muted);">SISTEM PRAKERIND & ABSENSI</div>
        </div>
    </main>

    {{-- Bottom Navigation --}}
    <nav class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i>
            <span>Home</span>
        </a>

        <a href="{{ route('attendance.checkin') }}" class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
            <i data-lucide="fingerprint"></i>
            <span>Absen</span>
        </a>

        @if(auth()->user()->isSiswa())
        <a href="{{ route('journals.create') }}" class="nav-item fab {{ request()->routeIs('journals.create') ? 'active' : '' }}">
            <div class="fab-btn"><i data-lucide="plus"></i></div>
            <span style="margin-top:4px;">Tulis</span>
        </a>
        <a href="{{ route('journals.index') }}" class="nav-item {{ request()->routeIs('journals.index', 'journals.show', 'journals.edit') ? 'active' : '' }}">
            <i data-lucide="notebook-pen"></i>
            <span>Jurnal</span>
        </a>
        @endif

        @if(auth()->user()->isPembimbingIndustri())
        <a href="{{ route('validation.index') }}" class="nav-item {{ request()->routeIs('validation.*') ? 'active' : '' }}">
            <i data-lucide="check-circle"></i>
            <span>Validasi</span>
        </a>
        @endif

        @if(auth()->user()->isGuruPembimbing())
        <a href="{{ route('assessments.index') }}" class="nav-item {{ request()->routeIs('assessments.*') ? 'active' : '' }}">
            <i data-lucide="clipboard-check"></i>
            <span>Nilai</span>
        </a>
        <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i data-lucide="file-bar-chart"></i>
            <span>Laporan</span>
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i data-lucide="users"></i>
            <span>User</span>
        </a>
        <a href="{{ route('admin.industries.index') }}" class="nav-item {{ request()->routeIs('admin.industries.*') ? 'active' : '' }}">
            <i data-lucide="building-2"></i>
            <span>Industri</span>
        </a>
        <a href="{{ route('admin.periods.index') }}" class="nav-item {{ request()->routeIs('admin.periods.*') ? 'active' : '' }}">
            <i data-lucide="calendar-range"></i>
            <span>Periode</span>
        </a>
        @endif

        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i data-lucide="user"></i>
            <span>Profil</span>
        </a>
    </nav>
</div>
<script>lucide.createIcons();</script>
</body>
</html>
