@extends('layouts.app')
@section('title', 'Kelola Periode')
@section('content')
<div class="mb-4 text-right">
    <a href="{{ route('admin.periods.create') }}" class="btn btn-primary btn-block"><i class="lucide-plus"></i> Tambah Periode</a>
</div>
<div class="data-list">
    @forelse($periods as $p)
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <i class="lucide-calendar-range" style="color:var(--accent-light);"></i>
                <div>
                    <div>{{ $p->name }}</div>
                    <div class="data-item-subtitle">{{ $p->start_date->format('d M y') }} — {{ $p->end_date->format('d M y') }}</div>
                </div>
            </div>
            <span class="badge {{ $p->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <div class="data-item-body">
            <div>Peserta: {{ $p->users_count }} Siswa</div>
        </div>
        <div class="data-item-footer">
            <a href="{{ route('admin.periods.edit', $p) }}" class="btn btn-secondary btn-sm"><i class="lucide-pencil"></i></a>
            <form method="POST" action="{{ route('admin.periods.destroy', $p) }}" onsubmit="return confirm('Hapus?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="lucide-trash-2"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada data periode</div>
    @endforelse
</div>
<div class="mt-4">{{ $periods->links() }}</div>
@endsection
