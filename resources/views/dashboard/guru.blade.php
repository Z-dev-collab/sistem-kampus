@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('subtitle', 'Selamat datang, ' . $user->name)
@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="lucide-users"></i></div>
        <div class="stat-value">{{ $stats['total_students'] }}</div>
        <div class="stat-label">Siswa Bimbingan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="lucide-notebook-pen"></i></div>
        <div class="stat-value">{{ $stats['total_journals'] }}</div>
        <div class="stat-label">Total Jurnal</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="lucide-check-circle"></i></div>
        <div class="stat-value">{{ $stats['verified_journals'] }}</div>
        <div class="stat-label">Jurnal Terverifikasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="lucide-percent"></i></div>
        <div class="stat-value">{{ $stats['attendance_rate'] }}%</div>
        <div class="stat-label">Kehadiran</div>
    </div>
</div>

<h3 style="margin-bottom:12px;font-size:15px;display:flex;align-items:center;gap:8px;">
    <i class="lucide-users" style="color:var(--accent-light)"></i> Daftar Siswa Bimbingan
</h3>
<div class="data-list">
    @forelse($students as $s)
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <img src="{{ $s->photo_url }}" style="width:36px;height:36px;border-radius:50%;">
                <div>
                    <div>{{ $s->name }}</div>
                    <div class="data-item-subtitle">{{ $s->kelas }} · {{ $s->industry?->name ?? '-' }}</div>
                </div>
            </div>
            <a href="{{ route('reports.student', $s) }}" class="btn btn-secondary btn-sm"><i class="lucide-file-text"></i> Lihat</a>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada siswa bimbingan</div>
    @endforelse
</div>
@endsection
