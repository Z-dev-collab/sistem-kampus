@extends('layouts.app')
@section('title', 'Profil')
@section('subtitle', 'Pengaturan akun')
@section('content')
<div class="grid-2">
    <div class="card">
        <div class="card-header"><h3><i class="lucide-user" style="color:var(--accent-light)"></i> Informasi Profil</h3></div>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="text-center mb-4">
                <img src="{{ $user->photo_url }}" style="width:80px;height:80px;border-radius:50%;margin-bottom:12px;">
                <div><input type="file" name="photo" class="form-control" style="max-width:250px;margin:0 auto;" accept="image/*"></div>
            </div>
            <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-control" value="{{ $user->email }}" disabled></div>
            <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
            <button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Simpan</button>
        </form>
    </div>
    <div class="card">
        <div class="card-header"><h3><i class="lucide-lock" style="color:var(--accent-light)"></i> Ubah Password</h3></div>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">Password Lama</label><input type="password" name="current_password" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Konfirmasi</label><input type="password" name="password_confirmation" class="form-control" required></div>
            <button type="submit" class="btn btn-primary btn-block"><i data-lucide="key"></i> Ubah Password</button>
        </form>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('logout') }}" class="btn btn-danger btn-block" style="padding: 16px; font-size: 15px;">
        <i data-lucide="log-out"></i> Keluar dari Aplikasi
    </a>
</div>
@endsection
