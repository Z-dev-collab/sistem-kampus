<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Industry;
use App\Models\Period;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match($user->role) {
            'siswa' => $this->siswa($user),
            'pembimbing_industri' => $this->pembimbing($user),
            'guru_pembimbing' => $this->guru($user),
            'admin' => $this->admin($user),
            default => abort(403),
        };
    }

    private function siswa($user)
    {
        $today = Carbon::today();
        $todayAttendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        $todayJournal = Journal::where('user_id', $user->id)->where('date', $today)->first();

        $stats = [
            'total_journals' => Journal::where('user_id', $user->id)->count(),
            'verified_journals' => Journal::where('user_id', $user->id)->terverifikasi()->count(),
            'pending_journals' => Journal::where('user_id', $user->id)->menunggu()->count(),
            'total_attendance' => Attendance::where('user_id', $user->id)->where('status', 'hadir')->count(),
            'total_days' => Attendance::where('user_id', $user->id)->count(),
        ];

        $recentJournals = Journal::where('user_id', $user->id)->latest('date')->take(5)->get();

        return view('dashboard.siswa', compact('user', 'todayAttendance', 'todayJournal', 'stats', 'recentJournals'));
    }

    private function pembimbing($user)
    {
        $students = User::where('pembimbing_industri_id', $user->id)->where('role', 'siswa')->get();
        $studentIds = $students->pluck('id');

        $stats = [
            'total_students' => $students->count(),
            'pending_journals' => Journal::whereIn('user_id', $studentIds)->menunggu()->count(),
            'verified_today' => Journal::whereIn('user_id', $studentIds)->terverifikasi()->whereDate('updated_at', Carbon::today())->count(),
            'total_verified' => Journal::whereIn('user_id', $studentIds)->terverifikasi()->count(),
        ];

        $pendingJournals = Journal::whereIn('user_id', $studentIds)->menunggu()->with('user')->latest('date')->take(10)->get();

        return view('dashboard.pembimbing', compact('user', 'students', 'stats', 'pendingJournals'));
    }

    private function guru($user)
    {
        $students = User::where('guru_pembimbing_id', $user->id)->where('role', 'siswa')->get();
        $studentIds = $students->pluck('id');

        $stats = [
            'total_students' => $students->count(),
            'total_journals' => Journal::whereIn('user_id', $studentIds)->count(),
            'verified_journals' => Journal::whereIn('user_id', $studentIds)->terverifikasi()->count(),
            'attendance_rate' => $studentIds->count() > 0
                ? round(Attendance::whereIn('user_id', $studentIds)->where('status', 'hadir')->count() / max(Attendance::whereIn('user_id', $studentIds)->count(), 1) * 100, 1)
                : 0,
        ];

        return view('dashboard.guru', compact('user', 'students', 'stats'));
    }

    private function admin($user)
    {
        $stats = [
            'total_users' => User::count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_industries' => Industry::count(),
            'total_periods' => Period::count(),
            'active_period' => Period::active()->first(),
            'total_journals' => Journal::count(),
            'total_attendances' => Attendance::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard.admin', compact('user', 'stats', 'recentUsers'));
    }
}
