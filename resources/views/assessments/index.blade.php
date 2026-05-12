@extends('layouts.app')
@section('title', 'Penilaian Siswa')
@section('subtitle', 'Pilih siswa untuk dinilai')
@section('content')
<div class="data-list">
    @forelse($students as $s)
    @php $assessment = $s->assessments->first(); @endphp
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <img src="{{ $s->photo_url }}" style="width:36px;height:36px;border-radius:50%;">
                <div>
                    <div>{{ $s->name }}</div>
                    <div class="data-item-subtitle">{{ $s->kelas }} · {{ $s->industry?->name ?? '-' }}</div>
                </div>
            </div>
            @if($assessment)
            <div style="text-align:right;">
                <div style="font-size:10px;color:var(--text-muted);">Nilai</div>
                <div style="font-weight:800;font-size:20px;color:var(--accent-light);">{{ $assessment->total_score }}</div>
            </div>
            @else
            <span class="badge badge-warning">Belum</span>
            @endif
        </div>
        <div class="data-item-footer" style="justify-content: flex-end;">
            <a href="{{ route('assessments.create', $s) }}" class="btn btn-primary btn-sm"><i class="lucide-pencil"></i> {{ $assessment ? 'Edit Nilai' : 'Beri Nilai' }}</a>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada siswa bimbingan</div>
    @endforelse
</div>
@endsection
