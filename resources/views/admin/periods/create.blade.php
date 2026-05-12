@extends('layouts.app')
@section('title', 'Tambah Periode')
@section('content')
<div class="card" style="max-width:500px;">
    <form method="POST" action="{{ route('admin.periods.store') }}">
        @csrf
        <div class="form-group"><label class="form-label">Nama Periode</label><input type="text" name="name" class="form-control" placeholder="Contoh: Prakerind 2026 Semester 1" required></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Tanggal Mulai</label><input type="date" name="start_date" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Tanggal Selesai</label><input type="date" name="end_date" class="form-control" required></div>
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" checked style="accent-color:var(--accent);" id="isActive">
            <label for="isActive" style="cursor:pointer;">Aktif</label>
        </div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Simpan</button><a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
@endsection
