@extends('layouts.app')
@section('title', 'Kelola User')
@section('subtitle', 'Manajemen pengguna sistem')
@section('content')
<div class="mb-4">
    <form style="display:flex;gap:8px;flex-direction:column;">
        <div style="display:flex;gap:8px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
            <select name="role" class="form-control" style="width:130px;" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="siswa" {{ request('role')=='siswa'?'selected':'' }}>Siswa</option>
                <option value="pembimbing_industri" {{ request('role')=='pembimbing_industri'?'selected':'' }}>Pembimbing</option>
                <option value="guru_pembimbing" {{ request('role')=='guru_pembimbing'?'selected':'' }}>Guru</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;">
            <button type="submit" class="btn btn-secondary" style="flex:1;"><i class="lucide-search"></i> Cari</button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="flex:1;"><i class="lucide-user-plus"></i> Tambah</a>
        </div>
    </form>
</div>

<div class="data-list">
    @forelse($users as $u)
    <div class="data-item">
        <div class="data-item-header">
            <div class="data-item-title">
                <img src="{{ $u->photo_url }}" style="width:36px;height:36px;border-radius:50%;">
                <div>
                    <div>{{ $u->name }}</div>
                    <div class="data-item-subtitle">{{ $u->email }}</div>
                </div>
            </div>
            <span class="badge {{ $u->is_active ? 'badge-success' : 'badge-danger' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <div class="data-item-body">
            <span class="badge badge-info">{{ str_replace('_',' ',$u->role) }}</span>
            @if($u->role === 'siswa')
            <span class="text-sm ml-2"> · {{ $u->kelas }}</span>
            @endif
        </div>
        <div class="data-item-footer">
            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-secondary btn-sm"><i class="lucide-pencil"></i> Edit</a>
            @if($u->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="lucide-trash-2"></i></button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center text-muted mt-4">Belum ada data user.</div>
    @endforelse
</div>
<div class="mt-4">{{ $users->withQueryString()->links() }}</div>
@endsection
