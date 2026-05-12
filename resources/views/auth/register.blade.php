@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="brand-icon"><img src="{{ asset('logo.png') }}" alt="Logo"></div>
            <h1>Daftar Akun</h1>
            <p>Buat akun siswa baru</p>
        </div>
        @if($errors->any())
        <div class="alert alert-error"><i class="lucide-alert-circle"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <i class="lucide-user-plus"></i> Daftar
            </button>
        </form>
        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
