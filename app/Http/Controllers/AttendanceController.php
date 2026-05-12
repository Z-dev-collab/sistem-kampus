<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Industry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Attendance::where('user_id', $user->id);

        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)->whereYear('date', $date->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->paginate(15);

        // Statistics
        $monthQuery = Attendance::where('user_id', $user->id);
        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $monthQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
        } else {
            $monthQuery->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year);
        }

        $stats = [
            'hadir' => (clone $monthQuery)->where('status', 'hadir')->count(),
            'izin' => (clone $monthQuery)->where('status', 'izin')->count(),
            'sakit' => (clone $monthQuery)->where('status', 'sakit')->count(),
            'alpha' => (clone $monthQuery)->where('status', 'alpha')->count(),
        ];

        return view('attendances.index', compact('attendances', 'stats'));
    }

    public function checkin()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $todayAttendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        $industry = $user->industry;

        return view('attendances.checkin', compact('todayAttendance', 'industry'));
    }

    public function storeCheckin(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user();
        $today = Carbon::today();
        $now = Carbon::now();

        $existing = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        if ($existing && $existing->check_in_time) {
            return back()->with('error', 'Anda sudah check-in hari ini.');
        }

        // Validate geofence
        $isValid = true;
        if ($user->industry && $user->industry->latitude) {
            $isValid = $user->industry->isWithinGeofence($request->latitude, $request->longitude);
        }

        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'check_in_time' => $now,
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'status' => 'hadir',
                'is_valid' => $isValid,
            ]
        );

        $message = $isValid
            ? 'Check-in berhasil! Lokasi terverifikasi.'
            : 'Check-in berhasil, namun lokasi di luar area industri.';

        return back()->with('success', $message);
    }

    public function storeCheckout(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user();
        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if (!$attendance || !$attendance->check_in_time) {
            return back()->with('error', 'Anda belum check-in hari ini.');
        }

        if ($attendance->check_out_time) {
            return back()->with('error', 'Anda sudah check-out hari ini.');
        }

        $attendance->update([
            'check_out_time' => $now,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Check-out berhasil!');
    }
}
