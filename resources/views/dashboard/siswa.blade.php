@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('subtitle', 'Selamat datang, ' . $user->name)
@section('content')
<div class="stats-grid">
    <div class="stat-card teal">
        <div class="stat-icon"><i class="lucide-notebook-pen"></i></div>
        <div class="stat-value">{{ $stats['total_journals'] }}</div>
        <div class="stat-label">Total Jurnal</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="lucide-check-circle"></i></div>
        <div class="stat-value">{{ $stats['verified_journals'] }}</div>
        <div class="stat-label">Terverifikasi</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="lucide-clock"></i></div>
        <div class="stat-value">{{ $stats['pending_journals'] }}</div>
        <div class="stat-label">Menunggu Validasi</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="lucide-calendar-check"></i></div>
        <div class="stat-value">{{ $stats['total_attendance'] }}/{{ $stats['total_days'] }}</div>
        <div class="stat-label">Kehadiran</div>
    </div>
</div>

<div class="grid-2">
    {{-- Quick Actions --}}
    <div class="card">
        <div class="card-header"><h3><i class="lucide-zap" style="color:var(--accent-light)"></i> Aksi Cepat</h3></div>
        <div style="display:flex;flex-direction:column;gap:12px;">
            @if(!$todayAttendance || !$todayAttendance->check_in_time)
            <a href="{{ route('attendance.checkin') }}" class="btn btn-primary btn-block">
                <i class="lucide-map-pin"></i> Check-in Hari Ini
            </a>
            @elseif(!$todayAttendance->check_out_time)
            <a href="{{ route('attendance.checkin') }}" class="btn btn-warning btn-block">
                <i class="lucide-map-pin-off"></i> Check-out Hari Ini
            </a>
            @else
            <div class="btn btn-success btn-block" style="cursor:default;opacity:0.8;">
                <i class="lucide-check"></i> Absensi Hari Ini Selesai
            </div>
            @endif

            @if(!$todayJournal)
            <a href="{{ route('journals.create') }}" class="btn btn-secondary btn-block">
                <i class="lucide-plus"></i> Tulis Jurnal Hari Ini
            </a>
            @else
            <a href="{{ route('journals.show', $todayJournal) }}" class="btn btn-secondary btn-block">
                <i class="lucide-eye"></i> Lihat Jurnal Hari Ini
            </a>
            @endif
        </div>
    </div>

    {{-- Recent Journals --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="lucide-history" style="color:var(--accent-light)"></i> Jurnal Terbaru</h3>
            <a href="{{ route('journals.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        @forelse($recentJournals as $journal)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border-glass);">
            <div>
                <div style="font-size:14px;font-weight:600;">{{ $journal->date->translatedFormat('d M Y') }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ Str::limit($journal->description, 40) }}</div>
            </div>
            <span class="badge {{ $journal->status_badge }}">{{ $journal->status_label }}</span>
        </div>
        @empty
        <div class="empty-state" style="padding:30px;">
            <i class="lucide-notebook-pen"></i>
            <p>Belum ada jurnal</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
