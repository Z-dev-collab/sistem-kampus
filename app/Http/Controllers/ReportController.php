<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isGuruPembimbing()) {
            $students = User::where('guru_pembimbing_id', $user->id)->where('role', 'siswa')->with('industry', 'assessments')->get();
        } elseif ($user->isAdmin()) {
            $students = User::where('role', 'siswa')->with('industry', 'assessments', 'guruPembimbing')->get();
        } else {
            $students = collect([auth()->user()]);
        }

        return view('reports.index', compact('students'));
    }

    public function studentReport(User $student)
    {
        $user = auth()->user();

        // Authorization
        if (!$user->isAdmin() && !$user->isGuruPembimbing()) {
            if ($student->id !== $user->id) abort(403);
        }

        $journals = Journal::where('user_id', $student->id)->latest('date')->get();
        $attendances = Attendance::where('user_id', $student->id)->latest('date')->get();
        $assessment = Assessment::where('user_id', $student->id)->latest()->first();

        $attendanceStats = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'alpha' => $attendances->where('status', 'alpha')->count(),
        ];

        $journalStats = [
            'total' => $journals->count(),
            'terverifikasi' => $journals->where('status', 'terverifikasi')->count(),
            'menunggu' => $journals->where('status', 'menunggu')->count(),
            'draft' => $journals->where('status', 'draft')->count(),
        ];

        return view('reports.student', compact('student', 'journals', 'attendances', 'assessment', 'attendanceStats', 'journalStats'));
    }
}
