@extends('layouts.app')
@section('title', 'Edit Industri')
@section('content')
<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.industries.update', $industry) }}">
        @csrf @method('PUT')
        <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $industry->name }}" required></div>
        <div class="form-group"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="3" required>{{ $industry->address }}</textarea></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ $industry->phone }}"></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $industry->email }}"></div>
        </div>
        <div class="form-group"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ $industry->contact_person }}"></div>
        <div class="grid-2">
            <div class="form-group"><label class="form-label">Latitude</label><input type="number" name="latitude" class="form-control" step="0.0000001" value="{{ $industry->latitude }}"></div>
            <div class="form-group"><label class="form-label">Longitude</label><input type="number" name="longitude" class="form-control" step="0.0000001" value="{{ $industry->longitude }}"></div>
        </div>
        <div class="form-group"><label class="form-label">Radius Geofence (meter)</label><input type="number" name="geofence_radius" class="form-control" value="{{ $industry->geofence_radius }}" min="10" max="5000"></div>
        <div class="btn-group"><button type="submit" class="btn btn-primary"><i class="lucide-save"></i> Update</button><a href="{{ route('admin.industries.index') }}" class="btn btn-secondary">Batal</a></div>
    </form>
</div>
@endsection
