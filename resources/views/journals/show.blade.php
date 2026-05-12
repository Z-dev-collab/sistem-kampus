@extends('layouts.app')
@section('title', 'Detail Jurnal')
@section('subtitle', $journal->date->translatedFormat('l, d F Y'))
@section('content')
<div style="max-width:700px;">
    <div class="card mb-4">
        <div class="flex-between mb-4">
            <span class="badge {{ $journal->status_badge }}">{{ $journal->status_label }}</span>
            @if($journal->status !== 'terverifikasi')
            <div class="btn-group">
                <a href="{{ route('journals.edit', $journal) }}" class="btn btn-secondary btn-sm"><i class="lucide-pencil"></i> Edit</a>
                <form method="POST" action="{{ route('journals.destroy', $journal) }}" onsubmit="return confirm('Hapus jurnal ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="lucide-trash-2"></i></button>
                </form>
            </div>
            @endif
        </div>
        @if($journal->competency_category)
        <div style="font-size:13px;color:var(--accent-light);margin-bottom:12px;"><i class="lucide-tag"></i> {{ $journal->competency_category }}</div>
        @endif
        <div style="font-size:15px;line-height:1.8;color:var(--text-secondary);">{!! nl2br(e($journal->description)) !!}</div>
    </div>

    @if($journal->photos->count() > 0)
    <div class="card mb-4">
        <div class="card-header"><h3><i class="lucide-image" style="color:var(--accent-light)"></i> Dokumentasi</h3></div>
        <div class="photo-grid">
            @foreach($journal->photos as $photo)
            <div class="photo-item">
                <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->caption }}">
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($journal->comments->count() > 0)
    <div class="card">
        <div class="card-header"><h3><i class="lucide-message-circle" style="color:var(--accent-light)"></i> Komentar</h3></div>
        <div class="comment-list">
            @foreach($journal->comments as $comment)
            <div class="comment-item">
                <img src="{{ $comment->user->photo_url }}" alt="">
                <div>
                    <div class="comment-meta"><strong>{{ $comment->user->name }}</strong> · {{ $comment->created_at->diffForHumans() }}</div>
                    <div class="comment-text">{{ $comment->comment }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
<a href="{{ route('journals.index') }}" class="btn btn-secondary mt-4"><i class="lucide-arrow-left"></i> Kembali</a>
@endsection
