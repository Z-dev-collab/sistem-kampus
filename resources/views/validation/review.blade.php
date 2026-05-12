@extends('layouts.app')
@section('title', 'Review Jurnal')
@section('subtitle', $journal->user->name . ' — ' . $journal->date->translatedFormat('d F Y'))
@section('content')
<div style="max-width:700px;">
    <div class="card mb-4">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
            <img src="{{ $journal->user->photo_url }}" style="width:44px;height:44px;border-radius:50%;">
            <div><div style="font-weight:700;">{{ $journal->user->name }}</div><div class="text-sm text-muted">{{ $journal->user->kelas }} · {{ $journal->user->jurusan }}</div></div>
            <span class="badge {{ $journal->status_badge }}" style="margin-left:auto;">{{ $journal->status_label }}</span>
        </div>
        @if($journal->competency_category)
        <div style="font-size:13px;color:var(--accent-light);margin-bottom:12px;"><i class="lucide-tag"></i> {{ $journal->competency_category }}</div>
        @endif
        <div style="font-size:15px;line-height:1.8;color:var(--text-secondary);">{!! nl2br(e($journal->description)) !!}</div>
    </div>

    @if($journal->photos->count())
    <div class="card mb-4">
        <div class="card-header"><h3>Dokumentasi</h3></div>
        <div class="photo-grid">
            @foreach($journal->photos as $photo)
            <div class="photo-item"><img src="{{ asset('storage/' . $photo->photo_path) }}"></div>
            @endforeach
        </div>
    </div>
    @endif

    @if($journal->comments->count())
    <div class="card mb-4">
        <div class="card-header"><h3>Komentar Sebelumnya</h3></div>
        <div class="comment-list">
            @foreach($journal->comments as $c)
            <div class="comment-item"><img src="{{ $c->user->photo_url }}"><div><div class="comment-meta"><strong>{{ $c->user->name }}</strong> · {{ $c->created_at->diffForHumans() }}</div><div class="comment-text">{{ $c->comment }}</div></div></div>
            @endforeach
        </div>
    </div>
    @endif

    @if($journal->status === 'menunggu' || $journal->status === 'revisi')
    <div class="grid-2">
        <div class="card">
            <h3 style="margin-bottom:16px;color:var(--success);"><i class="lucide-check-circle"></i> Setujui</h3>
            <form method="POST" action="{{ route('validation.approve', $journal) }}">
                @csrf
                <div class="form-group"><textarea name="comment" class="form-control" rows="3" placeholder="Komentar (opsional)..."></textarea></div>
                <button class="btn btn-success btn-block"><i class="lucide-check"></i> Verifikasi</button>
            </form>
        </div>
        <div class="card">
            <h3 style="margin-bottom:16px;color:var(--danger);"><i class="lucide-x-circle"></i> Tolak / Revisi</h3>
            <form method="POST" action="{{ route('validation.reject', $journal) }}">
                @csrf
                <div class="form-group"><textarea name="comment" class="form-control" rows="3" placeholder="Alasan penolakan (wajib)..." required></textarea></div>
                <button class="btn btn-danger btn-block"><i class="lucide-rotate-ccw"></i> Minta Revisi</button>
            </form>
        </div>
    </div>
    @endif
</div>
<a href="{{ route('validation.index') }}" class="btn btn-secondary mt-4"><i class="lucide-arrow-left"></i> Kembali</a>
@endsection
