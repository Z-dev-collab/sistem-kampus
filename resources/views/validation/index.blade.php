@extends('layouts.app')
@section('title', 'Validasi Jurnal')
@section('subtitle', 'Review jurnal siswa bimbingan')
@section('content')
<div class="mb-4">
    <form style="display:flex;gap:10px;">
        <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
            <option value="menunggu" {{ request('status','menunggu')=='menunggu'?'selected':'' }}>Menunggu Validasi</option>
            <option value="terverifikasi" {{ request('status')=='terverifikasi'?'selected':'' }}>Terverifikasi</option>
            <option value="revisi" {{ request('status')=='revisi'?'selected':'' }}>Perlu Revisi</option>
            <option value="" {{ request('status')==''&&request()->has('status')?'selected':'' }}>Semua</option>
        </select>
    </form>
</div>

@forelse($journals as $journal)
<div class="card mb-4">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
        <div style="display:flex;gap:12px;flex:1;">
            <img src="{{ $journal->user->photo_url }}" style="width:40px;height:40px;border-radius:50%;flex-shrink:0;">
            <div>
                <div style="font-weight:700;">{{ $journal->user->name }}</div>
                <div class="text-sm text-muted">{{ $journal->user->kelas }} · {{ $journal->date->translatedFormat('d M Y') }}</div>
                <p style="margin-top:8px;font-size:14px;color:var(--text-secondary);">{{ Str::limit($journal->description, 120) }}</p>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
            <span class="badge {{ $journal->status_badge }}">{{ $journal->status_label }}</span>
            <a href="{{ route('validation.review', $journal) }}" class="btn btn-primary btn-sm"><i class="lucide-eye"></i> Review</a>
        </div>
    </div>
</div>
@empty
<div class="card"><div class="empty-state"><i class="lucide-check-circle"></i><h3>Tidak Ada Jurnal</h3><p>Semua jurnal sudah divalidasi</p></div></div>
@endforelse
{{ $journals->withQueryString()->links() }}
@endsection
