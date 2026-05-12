@extends('layouts.app')
@section('title', 'Laporan')
@section('subtitle', 'Pilih siswa untuk melihat laporan')
@section('content')
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
            <a href="{{ route('reports.student', $s) }}" class="btn btn-secondary btn-sm"><i class="lucide-file-bar-chart"></i> Laporan</a>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada siswa bimbingan</div>
    @endforelse
</div>
@endsection
