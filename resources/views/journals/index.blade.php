@extends('layouts.app')
@section('title', 'Jurnal Harian')
@section('subtitle', 'Catatan kegiatan prakerind')
@section('content')
<div class="flex-between mb-6">
    <form style="display:flex;gap:10px;flex-wrap:wrap;">
        <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="menunggu" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
            <option value="revisi" {{ request('status')=='revisi'?'selected':'' }}>Revisi</option>
            <option value="terverifikasi" {{ request('status')=='terverifikasi'?'selected':'' }}>Terverifikasi</option>
        </select>
        <input type="month" name="month" class="form-control" style="width:auto;" value="{{ request('month') }}" onchange="this.form.submit()">
    </form>
    <a href="{{ route('journals.create') }}" class="btn btn-primary"><i class="lucide-plus"></i> Tulis Jurnal</a>
</div>

@forelse($journals as $journal)
<div class="card mb-4" style="cursor:pointer;" onclick="window.location='{{ route('journals.show', $journal) }}'">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <span style="font-weight:700;font-size:16px;">{{ $journal->date->translatedFormat('d M Y') }}</span>
                <span class="badge {{ $journal->status_badge }}">{{ $journal->status_label }}</span>
            </div>
            @if($journal->competency_category)
            <div style="font-size:12px;color:var(--accent-light);margin-bottom:6px;"><i class="lucide-tag"></i> {{ $journal->competency_category }}</div>
            @endif
            <p style="font-size:14px;color:var(--text-secondary);line-height:1.6;">{{ Str::limit($journal->description, 150) }}</p>
        </div>
        @if($journal->photos->count() > 0)
        <div style="margin-left:16px;flex-shrink:0;">
            <img src="{{ asset('storage/' . $journal->photos->first()->photo_path) }}" style="width:80px;height:80px;border-radius:var(--radius-sm);object-fit:cover;">
        </div>
        @endif
    </div>
</div>
@empty
<div class="card">
    <div class="empty-state">
        <i class="lucide-notebook-pen"></i>
        <h3>Belum Ada Jurnal</h3>
        <p>Mulai catat kegiatan prakerind Anda</p>
        <a href="{{ route('journals.create') }}" class="btn btn-primary"><i class="lucide-plus"></i> Tulis Jurnal Pertama</a>
    </div>
</div>
@endforelse

{{ $journals->withQueryString()->links() }}
@endsection
