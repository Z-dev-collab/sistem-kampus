@extends('layouts.app')
@section('title', 'Input Penilaian')
@section('subtitle', $student->name)
@section('content')
<div class="card" style="max-width:600px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--border-glass);">
        <img src="{{ $student->photo_url }}" style="width:48px;height:48px;border-radius:50%;">
        <div><div style="font-weight:700;font-size:16px;">{{ $student->name }}</div><div class="text-sm text-muted">{{ $student->kelas }} · {{ $student->jurusan }}</div></div>
    </div>
    <form method="POST" action="{{ route('assessments.store') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $student->id }}">
        <input type="hidden" name="period_id" value="{{ $activePeriod?->id }}">

        <div class="form-group">
            <label class="form-label">Soft Skill (25%)</label>
            <input type="number" name="soft_skill_score" class="form-control" min="0" max="100" step="0.01" value="{{ old('soft_skill_score', $existing?->soft_skill_score ?? '') }}" required>
            <div class="form-hint">Komunikasi, kerjasama, inisiatif</div>
        </div>
        <div class="form-group">
            <label class="form-label">Hard Skill (35%)</label>
            <input type="number" name="hard_skill_score" class="form-control" min="0" max="100" step="0.01" value="{{ old('hard_skill_score', $existing?->hard_skill_score ?? '') }}" required>
            <div class="form-hint">Keterampilan teknis sesuai jurusan</div>
        </div>
        <div class="form-group">
            <label class="form-label">Kedisiplinan (20%)</label>
            <input type="number" name="discipline_score" class="form-control" min="0" max="100" step="0.01" value="{{ old('discipline_score', $existing?->discipline_score ?? '') }}" required>
            <div class="form-hint">Kehadiran, ketepatan waktu</div>
        </div>
        <div class="form-group">
            <label class="form-label">Sikap & Attitude (20%)</label>
            <input type="number" name="attitude_score" class="form-control" min="0" max="100" step="0.01" value="{{ old('attitude_score', $existing?->attitude_score ?? '') }}" required>
            <div class="form-hint">Sopan santun, etika kerja</div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $existing?->notes ?? '') }}</textarea>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Simpan Penilaian</button>
            <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
