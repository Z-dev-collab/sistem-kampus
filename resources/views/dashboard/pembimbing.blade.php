@extends('layouts.app')
@section('title', 'Dashboard Pembimbing')
@section('subtitle', 'Selamat datang, ' . $user->name)
@section('content')
<div class="stats-grid">
    <div class="stat-card teal">
        <div class="stat-icon"><i class="lucide-users"></i></div>
        <div class="stat-value">{{ $stats['total_students'] }}</div>
        <div class="stat-label">Siswa Bimbingan</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="lucide-clock"></i></div>
        <div class="stat-value">{{ $stats['pending_journals'] }}</div>
        <div class="stat-label">Menunggu Validasi</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="lucide-check-circle"></i></div>
        <div class="stat-value">{{ $stats['verified_today'] }}</div>
        <div class="stat-label">Divalidasi Hari Ini</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="lucide-file-check"></i></div>
        <div class="stat-value">{{ $stats['total_verified'] }}</div>
        <div class="stat-label">Total Terverifikasi</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="lucide-clock" style="color:var(--warning)"></i> Jurnal Menunggu Validasi</h3>
        <a href="{{ route('validation.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    @forelse($pendingJournals as $journal)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border-glass);">
        <div style="display:flex;align-items:center;gap:12px;">
            <img src="{{ $journal->user->photo_url }}" style="width:36px;height:36px;border-radius:50%;">
            <div>
                <div style="font-weight:600;font-size:14px;">{{ $journal->user->name }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $journal->date->translatedFormat('d M Y') }} · {{ Str::limit($journal->description, 50) }}</div>
            </div>
        </div>
        <a href="{{ route('validation.review', $journal) }}" class="btn btn-primary btn-sm">Review</a>
    </div>
    @empty
    <div class="empty-state" style="padding:30px;">
        <i class="lucide-check-circle"></i>
        <h3>Semua Sudah Divalidasi</h3>
        <p>Tidak ada jurnal yang menunggu validasi</p>
    </div>
    @endforelse
</div>
@endsection
