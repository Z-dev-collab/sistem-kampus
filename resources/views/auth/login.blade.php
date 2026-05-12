@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="brand-icon"><img src="{{ asset('logo.png') }}" alt="Logo"></div>
            <h1>E-Journal Prakerind</h1>
            <p>Masuk ke akun Anda</p>
        </div>
        @if($errors->any())
        <div class="alert alert-error"><i class="lucide-alert-circle"></i> {{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" id="remember" style="accent-color:var(--accent)">
                <label for="remember" style="font-size:13px;color:var(--text-secondary);cursor:pointer;">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <i class="lucide-log-in"></i> Masuk
            </button>
        </form>
        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</div>
@endsection
