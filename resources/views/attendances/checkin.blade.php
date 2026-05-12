@extends('layouts.app')
@section('title', 'Presensi Kehadiran')
@section('subtitle', 'Lakukan check-in sesuai lokasi industri')
@section('content')
<div style="max-width:500px;margin:0 auto;">
    <div class="card" style="padding: 24px; position: relative;">
        @if(!$todayAttendance || !$todayAttendance->check_in_time)
            {{-- CHECK IN --}}
            <div id="map-placeholder" style="width: 100%; height: 200px; background: #f8fafc; border-radius: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted); border: 2px dashed #e2e8f0;">
                <i data-lucide="map-pin" style="width: 48px; height: 48px; color: var(--primary); margin-bottom: 15px; opacity: 0.5;"></i>
                <p id="status-text" style="font-weight: 500;">Mencari koordinat...</p>
            </div>

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-size: 14px;">
                <i data-lucide="building" style="color: var(--primary); width: 18px;"></i>
                <span>Target: <strong>{{ $industry ? $industry->name : 'Belum Ada Industri' }}</strong></span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; font-size: 14px;">
                <i data-lucide="navigation" id="dist-icon" style="color: var(--text-muted); width: 18px;"></i>
                <span id="distance-text">Menghitung jarak...</span>
            </div>

            <form method="POST" action="{{ route('attendance.store.checkin') }}" id="checkinForm">
                @csrf
                <input type="hidden" name="latitude" id="lat-input">
                <input type="hidden" name="longitude" id="lng-input">
                <button type="submit" id="btn-absen" class="btn btn-primary btn-block" style="display: flex; align-items: center; justify-content: center; gap: 10px;" disabled>
                    <i data-lucide="fingerprint" style="width: 20px;"></i>
                    <span>Kirim Presensi Sekarang</span>
                </button>
            </form>

        @elseif(!$todayAttendance->check_out_time)
            {{-- CHECK OUT --}}
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="background: rgba(245, 158, 11, 0.1); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i data-lucide="clock" style="color: #f59e0b; width: 40px; height: 40px;"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 700; color: #b45309; margin-bottom: 8px;">Sudah Presensi Masuk</h4>
                <p style="font-size: 14px; color: var(--text-muted);">Anda telah check-in pada jam <strong>{{ $todayAttendance->check_in_time->format('H:i') }} WIB</strong>.</p>
            </div>

            <div id="map-placeholder" style="width: 100%; height: 160px; background: #f8fafc; border-radius: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted); border: 2px dashed #e2e8f0;">
                <i data-lucide="map-pin" style="width: 40px; height: 40px; color: var(--primary); margin-bottom: 10px; opacity: 0.5;"></i>
                <p id="status-text" style="font-weight: 500; font-size: 14px;">Mencari koordinat...</p>
            </div>

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-size: 13px;">
                <i data-lucide="building" style="color: var(--primary); width: 16px;"></i>
                <span>Target: <strong>{{ $industry ? $industry->name : 'Belum Ada Industri' }}</strong></span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; font-size: 13px;">
                <i data-lucide="navigation" id="dist-icon" style="color: var(--text-muted); width: 16px;"></i>
                <span id="distance-text">Menghitung jarak...</span>
            </div>

            <form method="POST" action="{{ route('attendance.store.checkout') }}" id="checkinForm">
                @csrf
                <input type="hidden" name="latitude" id="lat-input">
                <input type="hidden" name="longitude" id="lng-input">
                <button type="submit" id="btn-absen" class="btn btn-warning btn-block" style="display: flex; align-items: center; justify-content: center; gap: 10px;" disabled>
                    <i data-lucide="map-pin-off" style="width: 20px;"></i>
                    <span>Kirim Presensi Pulang</span>
                </button>
            </form>

        @else
            {{-- DONE --}}
            <div style="text-align: center; padding: 20px 0;">
                <div style="background: rgba(16, 185, 129, 0.1); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i data-lucide="check-circle" style="color: #10b981; width: 40px; height: 40px;"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 700; color: #065f46; margin-bottom: 8px;">Presensi Selesai</h4>
                <p style="font-size: 14px; color: var(--text-muted);">Anda telah menyelesaikan absensi hari ini.</p>
                
                <div style="display:flex;justify-content:center;gap:40px;margin-top:24px; padding: 15px; background: #f8fafc; border-radius: 12px;">
                    <div>
                        <div class="text-muted text-sm" style="font-size: 12px; margin-bottom: 4px;">Check-in</div>
                        <div style="font-weight:700;color:var(--success);">{{ $todayAttendance->check_in_time->format('H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-muted text-sm" style="font-size: 12px; margin-bottom: 4px;">Check-out</div>
                        <div style="font-weight:700;color:var(--danger);">{{ $todayAttendance->check_out_time->format('H:i') }}</div>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <span class="badge {{ $todayAttendance->is_valid ? 'badge-success' : 'badge-warning' }}" style="font-size: 11px;">
                        {{ $todayAttendance->is_valid ? 'LOKASI VALID' : 'DI LUAR AREA' }}
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>

@if(!$todayAttendance || !$todayAttendance->check_out_time)
<script>
    const destLat = {{ $industry && $industry->latitude ? $industry->latitude : 'null' }};
    const destLng = {{ $industry && $industry->longitude ? $industry->longitude : 'null' }};
    const radius = {{ $industry && $industry->geofence_radius ? $industry->geofence_radius : 100 }};

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; 
        const φ1 = lat1 * Math.PI/180;
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;
        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; 
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            document.getElementById('lat-input').value = userLat;
            document.getElementById('lng-input').value = userLng;
            
            if(destLat === null || destLng === null) {
                document.getElementById('status-text').innerHTML = "Lokasi Berhasil Dikunci (Target Industri Belum Diatur)";
                document.getElementById('status-text').style.color = "#10b981";
                document.getElementById('distance-text').innerHTML = `Jarak tidak dapat dihitung`;
                document.getElementById('btn-absen').disabled = false;
                document.getElementById('dist-icon').style.color = "#10b981";
                return;
            }

            const distance = calculateDistance(userLat, userLng, destLat, destLng);
            document.getElementById('status-text').innerHTML = "Lokasi Berhasil Dikunci";
            document.getElementById('status-text').style.color = "#10b981";
            document.getElementById('distance-text').innerHTML = `Jarak: <strong>${Math.round(distance)} meter</strong>`;
            
            if (distance <= radius) {
                document.getElementById('btn-absen').disabled = false;
                document.getElementById('dist-icon').style.color = "#10b981";
            } else {
                document.getElementById('status-text').innerHTML = "Di Luar Radius!";
                document.getElementById('status-text').style.color = "#ef4444";
                document.getElementById('dist-icon').style.color = "#ef4444";
                document.getElementById('distance-text').innerHTML += " <br><small style='color:#ef4444'>(Maksimal " + radius + "m)</small>";
            }
        }, error => {
            document.getElementById('status-text').innerHTML = "Akses Lokasi Ditolak";
            document.getElementById('status-text').style.color = "#ef4444";
        }, { enableHighAccuracy: true });
    } else {
        document.getElementById('status-text').innerHTML = "Browser tidak mendukung Geo";
    }
</script>
@endif
@endsection
