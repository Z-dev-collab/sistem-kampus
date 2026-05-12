@extends('layouts.app')
@section('title', 'Laporan ' . $student->name)
@section('subtitle', $student->kelas . ' · ' . ($student->industry?->name ?? ''))
@section('content')
<div class="stats-grid">
    <div class="stat-card teal"><div class="stat-icon"><i class="lucide-notebook-pen"></i></div><div class="stat-value">{{ $journalStats['total'] }}</div><div class="stat-label">Total Jurnal</div></div>
    <div class="stat-card purple"><div class="stat-icon"><i class="lucide-check-circle"></i></div><div class="stat-value">{{ $journalStats['terverifikasi'] }}</div><div class="stat-label">Terverifikasi</div></div>
    <div class="stat-card blue"><div class="stat-icon"><i class="lucide-calendar-check"></i></div><div class="stat-value">{{ $attendanceStats['hadir'] }}</div><div class="stat-label">Hadir</div></div>
    <div class="stat-card orange"><div class="stat-icon"><i class="lucide-x"></i></div><div class="stat-value">{{ $attendanceStats['alpha'] }}</div><div class="stat-label">Alpha</div></div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-header"><h3>Rekap Kehadiran</h3></div>
        <div class="score-bar"><div class="score-header"><span>Hadir</span><span>{{ $attendanceStats['hadir'] }}</span></div><div class="bar"><div class="bar-fill teal" style="width:{{ $attendanceStats['hadir'] > 0 ? ($attendanceStats['hadir']/max(array_sum($attendanceStats),1)*100) : 0 }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Izin</span><span>{{ $attendanceStats['izin'] }}</span></div><div class="bar"><div class="bar-fill blue" style="width:{{ $attendanceStats['izin'] > 0 ? ($attendanceStats['izin']/max(array_sum($attendanceStats),1)*100) : 0 }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Sakit</span><span>{{ $attendanceStats['sakit'] }}</span></div><div class="bar"><div class="bar-fill orange" style="width:{{ $attendanceStats['sakit'] > 0 ? ($attendanceStats['sakit']/max(array_sum($attendanceStats),1)*100) : 0 }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Alpha</span><span>{{ $attendanceStats['alpha'] }}</span></div><div class="bar"><div class="bar-fill purple" style="width:{{ $attendanceStats['alpha'] > 0 ? ($attendanceStats['alpha']/max(array_sum($attendanceStats),1)*100) : 0 }}%"></div></div></div>
    </div>

    <div class="card">
        <div class="card-header"><h3>Penilaian</h3></div>
        @if($assessment)
        <div class="score-bar"><div class="score-header"><span>Soft Skill (25%)</span><span>{{ $assessment->soft_skill_score }}</span></div><div class="bar"><div class="bar-fill teal" style="width:{{ $assessment->soft_skill_score }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Hard Skill (35%)</span><span>{{ $assessment->hard_skill_score }}</span></div><div class="bar"><div class="bar-fill purple" style="width:{{ $assessment->hard_skill_score }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Kedisiplinan (20%)</span><span>{{ $assessment->discipline_score }}</span></div><div class="bar"><div class="bar-fill blue" style="width:{{ $assessment->discipline_score }}%"></div></div></div>
        <div class="score-bar"><div class="score-header"><span>Attitude (20%)</span><span>{{ $assessment->attitude_score }}</span></div><div class="bar"><div class="bar-fill orange" style="width:{{ $assessment->attitude_score }}%"></div></div></div>
        <div style="text-align:center;margin-top:20px;padding:16px;background:var(--accent-glow);border-radius:var(--radius-sm);">
            <div class="text-muted text-sm">Nilai Akhir</div>
            <div style="font-size:36px;font-weight:800;color:var(--accent-light);">{{ $assessment->total_score }}</div>
        </div>
        @else
        <div class="empty-state" style="padding:30px;"><p class="text-muted">Belum ada penilaian</p></div>
        @endif
    </div>
</div>

<a href="{{ route('reports.index') }}" class="btn btn-secondary mt-4"><i class="lucide-arrow-left"></i> Kembali</a>
@endsection
