@extends('layouts.app')
@section('title', 'Edit Jurnal')
@section('subtitle', $journal->date->translatedFormat('d F Y'))
@section('content')
<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('journals.update', $journal) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Kategori Kompetensi</label>
            <input type="text" name="competency_category" class="form-control" value="{{ old('competency_category', $journal->competency_category) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi Kegiatan</label>
            <textarea name="description" class="form-control" rows="6" required>{{ old('description', $journal->description) }}</textarea>
        </div>
        @if($journal->photos->count() > 0)
        <div class="form-group">
            <label class="form-label">Foto Saat Ini</label>
            <div class="photo-grid">
                @foreach($journal->photos as $photo)
                <div class="photo-item">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}">
                    <label style="position:absolute;top:8px;right:8px;background:rgba(239,68,68,0.8);padding:4px 8px;border-radius:4px;font-size:11px;cursor:pointer;">
                        <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" style="display:none;"> ✕ Hapus
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="form-group">
            <label class="form-label">Tambah Foto Baru</label>
            <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
        </div>
        <div class="btn-group">
            <button type="submit" name="draft" class="btn btn-secondary"><i class="lucide-save"></i> Simpan Draft</button>
            <button type="submit" name="submit" value="1" class="btn btn-primary"><i class="lucide-send"></i> Kirim Validasi</button>
            <a href="{{ route('journals.show', $journal) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
