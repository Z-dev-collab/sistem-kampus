@extends('layouts.app')
@section('title', 'Tulis Jurnal')
@section('subtitle', 'Catat kegiatan hari ini')
@section('content')
<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('journals.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Kategori Kompetensi</label>
            <input type="text" name="competency_category" class="form-control" placeholder="Contoh: Pemrograman Web, Database, dll" value="{{ old('competency_category') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi Kegiatan</label>
            <textarea name="description" class="form-control" rows="6" placeholder="Ceritakan kegiatan Anda hari ini secara detail..." required>{{ old('description') }}</textarea>
            <div class="form-hint">Minimal 10 karakter</div>
        </div>
        <div class="form-group">
            <label class="form-label">Foto Dokumentasi (Opsional)</label>
            <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
            <div class="form-hint">Maks. 5MB per foto. Format: JPG, PNG, WebP</div>
        </div>
        <div class="btn-group">
            <button type="submit" name="draft" class="btn btn-secondary"><i class="lucide-save"></i> Simpan Draft</button>
            <button type="submit" name="submit" value="1" class="btn btn-primary"><i class="lucide-send"></i> Kirim untuk Validasi</button>
        </div>
    </form>
</div>
@endsection
