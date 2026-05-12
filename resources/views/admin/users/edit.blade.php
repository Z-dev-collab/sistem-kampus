@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
        </div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Password (kosongkan jika tidak ubah)</label><input type="password" name="password" class="form-control"></div>
            <div class="form-group"><label class="form-label">Role</label>
                <select name="role" class="form-control" id="roleSelect" onchange="toggleFields()">
                    <option value="siswa" {{ $user->role=='siswa'?'selected':'' }}>Siswa</option>
                    <option value="pembimbing_industri" {{ $user->role=='pembimbing_industri'?'selected':'' }}>Pembimbing Industri</option>
                    <option value="guru_pembimbing" {{ $user->role=='guru_pembimbing'?'selected':'' }}>Guru Pembimbing</option>
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" id="isActive" {{ $user->is_active ? 'checked' : '' }} style="accent-color:var(--accent);">
            <label for="isActive" style="font-size:14px;cursor:pointer;">Akun Aktif</label>
        </div>
        <div id="siswaFields">
            <div class="grid-2">
                <div class="form-group"><label class="form-label">NISN</label><input type="text" name="nisn" class="form-control" value="{{ $user->nisn }}"></div>
                <div class="form-group"><label class="form-label">Kelas</label><input type="text" name="kelas" class="form-control" value="{{ $user->kelas }}"></div>
            </div>
            <div class="form-group"><label class="form-label">Jurusan</label><input type="text" name="jurusan" class="form-control" value="{{ $user->jurusan }}"></div>
            <div class="form-group"><label class="form-label">Industri</label>
                <select name="industry_id" class="form-control"><option value="">—</option>@foreach($industries as $i)<option value="{{ $i->id }}" {{ $user->industry_id==$i->id?'selected':'' }}>{{ $i->name }}</option>@endforeach</select>
            </div>
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Guru Pembimbing</label>
                    <select name="guru_pembimbing_id" class="form-control"><option value="">—</option>@foreach($guruList as $g)<option value="{{ $g->id }}" {{ $user->guru_pembimbing_id==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach</select>
                </div>
                <div class="form-group"><label class="form-label">Pembimbing Industri</label>
                    <select name="pembimbing_industri_id" class="form-control"><option value="">—</option>@foreach($pembimbingList as $p)<option value="{{ $p->id }}" {{ $user->pembimbing_industri_id==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach</select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Periode</label>
                <select name="period_id" class="form-control"><option value="">—</option>@foreach($periods as $p)<option value="{{ $p->id }}" {{ $user->period_id==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach</select>
            </div>
        </div>
        <div id="guruFields" style="display:none;">
            <div class="grid-2">
                <div class="form-group"><label class="form-label">NIP</label><input type="text" name="nip" class="form-control" value="{{ $user->nip }}"></div>
                <div class="form-group"><label class="form-label">Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ $user->jabatan }}"></div>
            </div>
        </div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Update</button><a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
<script>function toggleFields(){var r=document.getElementById('roleSelect').value;document.getElementById('siswaFields').style.display=r==='siswa'?'block':'none';document.getElementById('guruFields').style.display=(r==='guru_pembimbing'||r==='pembimbing_industri')?'block':'none';}toggleFields();</script>
@endsection
