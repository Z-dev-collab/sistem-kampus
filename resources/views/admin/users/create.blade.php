@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        </div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Role</label>
                <select name="role" class="form-control" id="roleSelect" onchange="toggleFields()" required>
                    <option value="siswa">Siswa</option>
                    <option value="pembimbing_industri">Pembimbing Industri</option>
                    <option value="guru_pembimbing">Guru Pembimbing</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        <div id="siswaFields">
            <div class="grid-2">
                <div class="form-group"><label class="form-label">NISN</label><input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}"></div>
                <div class="form-group"><label class="form-label">Kelas</label><input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}"></div>
            </div>
            <div class="form-group"><label class="form-label">Jurusan</label><input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}"></div>
            <div class="form-group"><label class="form-label">Industri</label>
                <select name="industry_id" class="form-control"><option value="">— Pilih Industri —</option>@foreach($industries as $i)<option value="{{ $i->id }}">{{ $i->name }}</option>@endforeach</select>
            </div>
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Guru Pembimbing</label>
                    <select name="guru_pembimbing_id" class="form-control"><option value="">— Pilih —</option>@foreach($guruList as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach</select>
                </div>
                <div class="form-group"><label class="form-label">Pembimbing Industri</label>
                    <select name="pembimbing_industri_id" class="form-control"><option value="">— Pilih —</option>@foreach($pembimbingList as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Periode</label>
                <select name="period_id" class="form-control"><option value="">— Pilih —</option>@foreach($periods as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select>
            </div>
        </div>
        <div id="guruFields" style="display:none;">
            <div class="grid-2">
                <div class="form-group"><label class="form-label">NIP</label><input type="text" name="nip" class="form-control"></div>
                <div class="form-group"><label class="form-label">Jabatan</label><input type="text" name="jabatan" class="form-control"></div>
            </div>
        </div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Simpan</button><a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
<script>
function toggleFields(){var r=document.getElementById('roleSelect').value;
document.getElementById('siswaFields').style.display=r==='siswa'?'block':'none';
document.getElementById('guruFields').style.display=(r==='guru_pembimbing'||r==='pembimbing_industri')?'block':'none';}
toggleFields();
</script>
@endsection
