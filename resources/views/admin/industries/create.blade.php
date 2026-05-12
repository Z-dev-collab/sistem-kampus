@extends('layouts.app')
@section('title', 'Tambah Industri')
@section('content')
<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.industries.store') }}">
        @csrf
        <div class="form-group"><label class="form-label">Nama Perusahaan</label><input type="text" name="name" class="form-control" required></div>
        <div class="form-group"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="3" required></textarea></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control"></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
        </div>
        <div class="form-group"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control"></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Latitude</label><input type="number" name="latitude" class="form-control" step="0.0000001"></div>
            <div class="form-group"><label class="form-label">Longitude</label><input type="number" name="longitude" class="form-control" step="0.0000001"></div>
        </div>
        <div class="form-group"><label class="form-label">Radius Geofence (meter)</label><input type="number" name="geofence_radius" class="form-control" value="100" min="10" max="5000"></div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Simpan</button><a href="{{ route('admin.industries.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
@endsection
