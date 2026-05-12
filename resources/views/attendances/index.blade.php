@extends('layouts.app')
@section('title', 'Riwayat Absensi')
@section('subtitle', 'Rekap kehadiran Anda')
@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#34d399;"><i class="lucide-check"></i></div>
        <div class="stat-value">{{ $stats['hadir'] }}</div><div class="stat-label">Hadir</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#fbbf24;"><i class="lucide-file-text"></i></div>
        <div class="stat-value">{{ $stats['izin'] }}</div><div class="stat-label">Izin</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(14,165,233,0.15);color:#38bdf8;"><i class="lucide-heart-pulse"></i></div>
        <div class="stat-value">{{ $stats['sakit'] }}</div><div class="stat-label">Sakit</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:#f87171;"><i class="lucide-x"></i></div>
        <div class="stat-value">{{ $stats['alpha'] }}</div><div class="stat-label">Alpha</div>
    </div>
</div>

<div class="mb-4">
    <form>
        <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()">
    </form>
</div>

<div class="data-list">
    @forelse($attendances as $a)
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <i class="lucide-calendar" style="color:var(--text-muted);"></i>
                <div>
                    <div>{{ $a->date->format('d M Y') }}</div>
                    <div class="data-item-subtitle">{{ $a->check_in_time ? $a->check_in_time->format('H:i') : '-' }} — {{ $a->check_out_time ? $a->check_out_time->format('H:i') : '-' }}</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                <span class="badge {{ $a->status_badge }}">{{ $a->status_label }}</span>
                <span class="badge {{ $a->is_valid ? 'badge-success' : 'badge-warning' }}">{{ $a->is_valid ? 'Lokasi Valid' : 'Di Luar Area' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada data absensi</div>
    @endforelse
</div>
<div class="mt-4">{{ $attendances->withQueryString()->links() }}</div>
@endsection
