@extends('layouts.app')
@section('title', 'Kelola Industri')
@section('content')
<div class="mb-4 text-right">
    <a href="{{ route('admin.industries.create') }}" class="btn btn-primary btn-block"><i class="lucide-plus"></i> Tambah Industri</a>
</div>
<div class="data-list">
    @forelse($industries as $i)
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <i class="lucide-building-2" style="color:var(--accent-light);"></i>
                <div>
                    <div>{{ $i->name }}</div>
                    <div class="data-item-subtitle">{{ Str::limit($i->address, 50) }}</div>
                </div>
            </div>
            <span class="badge badge-info">{{ $i->users_count }} Siswa</span>
        </div>
        <div class="data-item-body">
            @if($i->contact_person) <div><i class="lucide-user" style="width:14px;"></i> {{ $i->contact_person }}</div> @endif
            @if($i->phone) <div><i class="lucide-phone" style="width:14px;"></i> {{ $i->phone }}</div> @endif
        </div>
        <div class="data-item-footer">
            <a href="{{ route('admin.industries.edit', $i) }}" class="btn btn-secondary btn-sm"><i class="lucide-pencil"></i></a>
            <form method="POST" action="{{ route('admin.industries.destroy', $i) }}" onsubmit="return confirm('Hapus?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="lucide-trash-2"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada data industri</div>
    @endforelse
</div>
<div class="mt-4">{{ $industries->links() }}</div>
@endsection
