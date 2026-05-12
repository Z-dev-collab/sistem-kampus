@extends('layouts.app')
@section('title', 'Edit Periode')
@section('content')
<div class="card" style="max-width:500px;">
    <form method="POST" action="{{ route('admin.periods.update', $period) }}">
        @csrf @method('PUT')
        <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $period->name }}" required></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Mulai</label><input type="date" name="start_date" class="form-control" value="{{ $period->start_date->format('Y-m-d') }}" required></div>
            <div class="form-group"><label class="form-label">Selesai</label><input type="date" name="end_date" class="form-control" value="{{ $period->end_date->format('Y-m-d') }}" required></div>
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" {{ $period->is_active?'checked':'' }} style="accent-color:var(--accent);" id="isActive">
            <label for="isActive" style="cursor:pointer;">Aktif</label>
        </div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Update</button><a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
@endsection
