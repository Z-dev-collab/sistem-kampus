@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('subtitle', 'Panel Administrasi Sistem')
@section('content')
<div class="stats-grid">
    <div class="stat-card teal">
        <div class="stat-icon"><i class="lucide-users"></i></div>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total User</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="lucide-graduation-cap"></i></div>
        <div class="stat-value">{{ $stats['total_siswa'] }}</div>
        <div class="stat-label">Total Siswa</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="lucide-building-2"></i></div>
        <div class="stat-value">{{ $stats['total_industries'] }}</div>
        <div class="stat-label">Industri Mitra</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="lucide-notebook-pen"></i></div>
        <div class="stat-value">{{ $stats['total_journals'] }}</div>
        <div class="stat-label">Total Jurnal</div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-header">
            <h3><i class="lucide-calendar-range" style="color:var(--accent-light)"></i> Periode Aktif</h3>
        </div>
        @if($stats['active_period'])
        <div style="padding:16px;background:var(--accent-glow);border-radius:var(--radius-sm);border:1px solid rgba(13,148,136,0.3);">
            <div style="font-weight:700;font-size:16px;margin-bottom:4px;">{{ $stats['active_period']->name }}</div>
            <div class="text-sm text-muted">{{ $stats['active_period']->start_date->format('d M Y') }} — {{ $stats['active_period']->end_date->format('d M Y') }}</div>
        </div>
        @else
        <p class="text-muted">Belum ada periode aktif</p>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="lucide-user-plus" style="color:var(--accent-light)"></i> User Terbaru</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Kelola</a>
        </div>
        @foreach($recentUsers as $u)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border-glass);">
            <div style="display:flex;align-items:center;gap:10px;">
                <img src="{{ $u->photo_url }}" style="width:32px;height:32px;border-radius:50%;">
                <div><div style="font-weight:500;font-size:14px;">{{ $u->name }}</div></div>
            </div>
            <span class="badge badge-info">{{ str_replace('_',' ',$u->role) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
